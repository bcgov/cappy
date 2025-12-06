FROM alpine:3.19

# Install PHP 8.2 and extensions from Alpine repos
RUN apk add --no-cache \
    php82 \
    php82-fpm \
    php82-opcache \
    php82-mysqli \
    php82-pdo \
    php82-pdo_mysql \
    php82-pdo_pgsql \
    php82-mbstring \
    php82-xml \
    php82-openssl \
    php82-json \
    php82-phar \
    php82-zip \
    php82-gd \
    php82-dom \
    php82-session \
    php82-zlib \
    php82-curl \
    php82-exif \
    php82-fileinfo \
    php82-tokenizer \
    php82-xmlwriter \
    php82-simplexml \
    php82-ctype \
    php82-bcmath \
    php82-pcntl \
    php82-intl \
    nginx \
    supervisor \
    curl

# Create symlink for php command
RUN ln -s /usr/bin/php82 /usr/bin/php

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create non-root user
RUN addgroup -g 1000 laravel && \
    adduser -D -u 1000 -G laravel laravel

# Set working directory
WORKDIR /app

# Copy application files
COPY --chown=1000:1000 . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create necessary directories and set permissions for OpenShift arbitrary UIDs
RUN mkdir -p /app/storage/logs \
    /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/storage/framework/cache \
    /app/bootstrap/cache \
    /var/lib/nginx \
    /var/log/nginx \
    /run/nginx \
    /run/php-fpm82 \
    && chgrp -R 0 /app /var/lib/nginx /var/log/nginx /run/nginx /run/php-fpm82 \
    && chmod -R g=u /app /var/lib/nginx /var/log/nginx /run/nginx /run/php-fpm82 \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Configure nginx
RUN rm -f /etc/nginx/http.d/default.conf
COPY --chown=1000:0 <<'EOF' /etc/nginx/http.d/default.conf
server {
    listen 8080;
    server_name _;
    root /app/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
EOF

# Configure PHP-FPM
RUN sed -i 's/listen = .*/listen = 127.0.0.1:9000/' /etc/php82/php-fpm.d/www.conf \
    && sed -i 's/^user = .*/user = laravel/' /etc/php82/php-fpm.d/www.conf \
    && sed -i 's/^group = .*/group = laravel/' /etc/php82/php-fpm.d/www.conf \
    && sed -i 's/^;pid = .*/pid = \/app\/storage\/php-fpm82.pid/' /etc/php82/php-fpm.conf

# Configure nginx to run as non-root
RUN sed -i 's/user nginx;/user laravel;/' /etc/nginx/nginx.conf 2>/dev/null || true \
    && sed -i 's/^pid .*/pid \/app\/storage\/nginx.pid;/' /etc/nginx/nginx.conf

# Create supervisor config
COPY --chown=1000:0 <<'EOF' /etc/supervisord.conf
[supervisord]
nodaemon=true
user=laravel
logfile=/app/storage/logs/supervisord.log
pidfile=/app/storage/supervisord.pid

[program:php-fpm]
command=/usr/sbin/php-fpm82 -F
autostart=true
autorestart=true
stdout_logfile=/app/storage/logs/php-fpm.log
stderr_logfile=/app/storage/logs/php-fpm-error.log

[program:nginx]
command=nginx -g 'daemon off;'
autostart=true
autorestart=true
stdout_logfile=/app/storage/logs/nginx.log
stderr_logfile=/app/storage/logs/nginx-error.log
EOF

# Fix permissions for OpenShift's arbitrary UID
RUN chmod -R g=u /etc/nginx /etc/php82 /etc/supervisord.conf

# Switch to non-root user
USER 1000

# Expose port 8080 (non-privileged)
EXPOSE 8080

# Start supervisord
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
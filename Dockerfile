FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    git \
    curl \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create non-root user (OpenShift will override UID but we set up permissions)
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
    && chgrp -R 0 /app /var/lib/nginx /var/log/nginx /run/nginx /var/run \
    && chmod -R g=u /app /var/lib/nginx /var/log/nginx /run/nginx /var/run \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Configure nginx
RUN rm /etc/nginx/http.d/default.conf
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

# Configure PHP-FPM to run on port 9000 (not socket) and listen on localhost
RUN sed -i 's/listen = .*/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/^user = .*/user = laravel/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/^group = .*/group = laravel/' /usr/local/etc/php-fpm.d/www.conf

# Configure nginx to run as non-root
RUN sed -i 's/user nginx;/user laravel;/' /etc/nginx/nginx.conf 2>/dev/null || true

# Create supervisor config
COPY --chown=1000:0 <<'EOF' /etc/supervisord.conf
[supervisord]
nodaemon=true
user=laravel
logfile=/app/storage/logs/supervisord.log
pidfile=/app/storage/supervisord.pid

[program:php-fpm]
command=php-fpm
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
RUN chmod -R g=u /etc/nginx /etc/supervisord.conf /usr/local/etc/php-fpm.d

# Switch to non-root user
USER 1000

# Expose port 8080 (non-privileged)
EXPOSE 8080

# Start supervisord
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
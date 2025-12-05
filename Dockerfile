FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    postgresql-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create application directory and set permissions for OpenShift
RUN mkdir -p /app /var/run/nginx /var/log/nginx /var/lib/nginx/tmp \
    && chown -R 1001:0 /app /var/run /var/log/nginx /var/lib/nginx \
    && chmod -R g+rwX /app /var/run /var/log/nginx /var/lib/nginx

WORKDIR /app

# Copy application files
COPY --chown=1001:0 . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set up Laravel directories with proper permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    bootstrap/cache \
    && chown -R 1001:0 storage bootstrap/cache \
    && chmod -R g+rwX storage bootstrap/cache

# Configure Nginx for non-root
RUN echo 'pid /tmp/nginx.pid;' > /etc/nginx/nginx.conf \
    && cat >> /etc/nginx/nginx.conf <<'EOF'
worker_processes auto;
error_log /var/log/nginx/error.log;

events {
    worker_connections 1024;
}

http {
    include /etc/nginx/mime.types;
    default_type application/octet-stream;
    
    access_log /var/log/nginx/access.log;
    sendfile on;
    keepalive_timeout 65;
    
    client_body_temp_path /tmp/client_body;
    proxy_temp_path /tmp/proxy_temp;
    fastcgi_temp_path /tmp/fastcgi_temp;
    uwsgi_temp_path /tmp/uwsgi_temp;
    scgi_temp_path /tmp/scgi_temp;
    
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
        
        location ~ /\.(?!well-known).* {
            deny all;
        }
    }
}
EOF

# Configure PHP-FPM for non-root
RUN sed -i 's/listen = 9000/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;pid = run\/php-fpm.pid/pid = \/tmp\/php-fpm.pid/' /usr/local/etc/php-fpm.conf \
    && sed -i 's/user = www-data/user = 1001/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/group = www-data/group = 0/' /usr/local/etc/php-fpm.d/www.conf

# PHP production optimizations
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
    && echo 'opcache.enable=1' >> /usr/local/etc/php/php.ini \
    && echo 'opcache.memory_consumption=256' >> /usr/local/etc/php/php.ini \
    && echo 'opcache.interned_strings_buffer=16' >> /usr/local/etc/php/php.ini \
    && echo 'opcache.max_accelerated_files=10000' >> /usr/local/etc/php/php.ini

# Configure Supervisor
RUN cat > /etc/supervisord.conf <<'EOF'
[supervisord]
nodaemon=true
user=1001
logfile=/tmp/supervisord.log
pidfile=/tmp/supervisord.pid

[program:php-fpm]
command=/usr/local/sbin/php-fpm -F
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
autorestart=true

[program:nginx]
command=/usr/sbin/nginx -g 'daemon off;'
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
autorestart=true
EOF

# Switch to non-root user
USER 1001

# Expose port 8080 (standard for OpenShift)
EXPOSE 8080

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s \
    CMD php artisan inspire || exit 1

# Start supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
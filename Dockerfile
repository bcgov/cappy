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
    bash \
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

# Create necessary directories with proper permissions for OpenShift random UID
# OpenShift runs containers with random UID but GID 0 (root group)
RUN mkdir -p /app \
    /var/run/nginx \
    /var/log/nginx \
    /var/lib/nginx/tmp \
    /var/lib/nginx/logs \
    /tmp/sessions \
    /tmp/nginx-cache \
    && chmod -R g+rwX /var/run /var/log /var/lib/nginx /tmp \
    && chgrp -R 0 /var/run /var/log /var/lib/nginx /tmp \
    && chmod -R g+rwX /app \
    && chgrp -R 0 /app

WORKDIR /app

# Copy application files
COPY --chown=1001:0 . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set up Laravel directories with proper permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    bootstrap/cache \
    && chmod -R g+rwX storage bootstrap/cache \
    && chgrp -R 0 storage bootstrap/cache

# Configure Nginx for non-root with group permissions
RUN cat > /etc/nginx/nginx.conf <<'EOF'
# Run nginx as user 1001, group 0 (OpenShift compatible)
# OpenShift will override the user with a random UID, but GID stays 0
pid /tmp/nginx.pid;
worker_processes auto;
error_log /var/log/nginx/error.log warn;

events {
    worker_connections 1024;
}

http {
    include /etc/nginx/mime.types;
    default_type application/octet-stream;
    
    access_log /var/log/nginx/access.log;
    sendfile on;
    keepalive_timeout 65;
    
    # All temp paths must be writable by group 0
    client_body_temp_path /tmp/nginx-client-body;
    proxy_temp_path /tmp/nginx-proxy;
    fastcgi_temp_path /tmp/nginx-fastcgi;
    uwsgi_temp_path /tmp/nginx-uwsgi;
    scgi_temp_path /tmp/nginx-scgi;
    
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

# Create custom PHP-FPM config that doesn't require root
RUN cat > /usr/local/etc/php-fpm.d/zz-custom.conf <<'EOF'
[global]
pid = /tmp/php-fpm.pid
error_log = /proc/self/fd/2
daemonize = no

[www]
; OpenShift runs with random UID but GID 0
user = nobody
group = root

listen = 127.0.0.1:9000
listen.owner = nobody
listen.group = root

pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3

; Redirect logs to stdout/stderr
access.log = /proc/self/fd/2
php_admin_value[error_log] = /proc/self/fd/2
php_admin_flag[log_errors] = on

; Session path thats writable
php_value[session.save_path] = /tmp/sessions

clear_env = no
catch_workers_output = yes
EOF

# PHP production optimizations
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
    && cat >> /usr/local/etc/php/php.ini <<'EOF'
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
session.save_path=/tmp/sessions
EOF

# Configure Supervisor to run as non-root
RUN cat > /etc/supervisord.conf <<'EOF'
[supervisord]
nodaemon=true
logfile=/tmp/supervisord.log
pidfile=/tmp/supervisord.pid
user=nobody

[program:php-fpm]
command=/usr/local/sbin/php-fpm -F -R
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
autorestart=true
priority=1

[program:nginx]
command=/usr/sbin/nginx -g 'daemon off;'
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
autorestart=true
priority=2
EOF

# Create entrypoint script to handle random OpenShift UID
RUN cat > /app/docker-entrypoint.sh <<'EOF'
#!/bin/bash
set -e

# Fix permissions at runtime for OpenShift random UID
# The container runs with a random UID but always GID 0
echo "Setting up permissions for UID $(id -u)..."

# Ensure critical directories are writable
chmod -R g+rwX /tmp /var/log/nginx /var/lib/nginx 2>/dev/null || true

# Laravel specific directories
if [ -d "/app/storage" ]; then
    chmod -R g+rwX /app/storage /app/bootstrap/cache 2>/dev/null || true
fi

# Start supervisord
echo "Starting services..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
EOF

RUN chmod +x /app/docker-entrypoint.sh \
    && chgrp 0 /app/docker-entrypoint.sh \
    && chmod g+rwX /app/docker-entrypoint.sh

# Set proper permissions for OpenShift
RUN chmod -R g+rwX /app \
    && chgrp -R 0 /app \
    && chmod -R g+rwX /etc/nginx \
    && chgrp -R 0 /etc/nginx

# The container will run with a random UID assigned by OpenShift

# Expose port 8080 (standard for OpenShift)
EXPOSE 8080

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s \
    CMD php artisan inspire || exit 1

# Use entrypoint to handle dynamic permissions
ENTRYPOINT ["/app/docker-entrypoint.sh"]
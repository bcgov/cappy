# Use Laravel image
FROM ghcr.io/shinsenter/laravel:php8.2-nginx

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Set proper permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
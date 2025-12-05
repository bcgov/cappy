FROM php:8.2-apache

WORKDIR /var/www/html

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libicu-dev libpq-dev libzip-dev libpng-dev libonig-dev libxml2-dev zip unzip git curl \
 && docker-php-ext-install intl zip pdo_mysql pdo_pgsql mbstring exif bcmath gd pcntl \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set storage permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8080

CMD ["apache2-foreground"]

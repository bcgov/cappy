FROM wyveo/nginx-php-fpm:php82

# Work directory
WORKDIR /usr/share/nginx/html

# Copy Laravel app
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node & build assets
RUN apt-get update && apt-get install -y npm && rm -rf /var/lib/apt/lists/* \
 && [ -f package.json ] && npm install && npm run build || true

# OpenShift permissions
RUN mkdir -p storage bootstrap/cache \
 && chmod -R ug+rwX storage bootstrap/cache

# Expose nginx port
EXPOSE 8080

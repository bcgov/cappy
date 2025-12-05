FROM php:8.2-apache

RUN a2enmod rewrite

WORKDIR /var/www

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN apt-get update && apt-get install -y npm && rm -rf /var/lib/apt/lists/* \
 && npm install && npm run build

RUN chmod -R ug+rwX storage bootstrap/cache

EXPOSE 8080

CMD ["apache2-foreground"]

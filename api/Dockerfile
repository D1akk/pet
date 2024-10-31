FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    zip \
    && docker-php-ext-install pdo pdo_pgsql fileinfo


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/api/
COPY . .

RUN composer install

RUN php artisan key:generate

# RUN wait-for-it postgres:5432 -- php artisan migrate --force

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

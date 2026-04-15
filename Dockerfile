FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y git unzip libzip-dev
RUN docker-php-ext-install pdo pdo_mysql zip

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public
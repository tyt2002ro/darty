FROM php:8.1.10-fpm-bullseye

RUN pecl install xdebug-3.1.0 \
    && docker-php-ext-enable xdebug

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y --no-install-recommends \
    git

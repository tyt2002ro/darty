FROM php:8.1.10-fpm-bullseye

ARG uid=1000
RUN set -eux; \
    \
    usermod -u "${uid}" www-data;

RUN pecl install xdebug-3.1.0 \
    && docker-php-ext-enable xdebug

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y --no-install-recommends \
    git

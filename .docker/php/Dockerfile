ARG docker_registry=docker.io
FROM ${docker_registry}/php:8.1.10-fpm-bullseye

ARG USER_ID=10704
ARG GROUP_ID=1000

RUN usermod -u $USER_ID www-data
RUN groupmod -g $GROUP_ID www-data
RUN chown -R www-data:www-data /var/www

RUN pecl install xdebug-3.1.0 \
    && docker-php-ext-enable xdebug

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y --no-install-recommends \
    git

USER www-data

EXPOSE 9000

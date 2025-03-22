FROM composer:latest AS deps

WORKDIR /app

COPY . .

RUN --mount=type=bind,source=composer.json,target=composer.json \
    --mount=type=bind,source=composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --no-interaction

FROM php:8.4-fpm

# PHP Extension
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y vim less grep nginx supervisor && \
    mkdir -p /var/log/supervisor && \
    echo "alias ll='ls -la'" >> ~/.bashrc && echo "alias c='clear'" >> ~/.bashrc && \
    install-php-extensions gd zip pcntl oci8 pdo_oci pgsql pdo_pgsql && \
    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY ./.docker/supervisor.conf /etc/supervisor/supervisor.conf
COPY .docker/supervisor /etc/supervisor/conf.d
 
COPY .docker/php-config.ini "$PHP_INI_DIR/conf.d"

COPY .docker/nginx.conf /etc/nginx/sites-available/default

COPY --from=deps /app /var/www/html

RUN php artisan storage:link && chown -R www-data:www-data /var/www

EXPOSE 8000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf", "-n"]
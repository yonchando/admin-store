FROM php:8.4-fpm

ARG USER="web"

WORKDIR /var/www/html

# PHP Extension
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y vim less grep nginx supervisor && \
    mkdir -p /var/log/supervisor && \
    install-php-extensions gd zip pcntl oci8 pdo_oci pgsql pdo_pgsql 

# COPY
COPY app app
COPY bootstrap bootstrap
COPY config config
COPY database database
COPY lang lang
COPY public public
COPY resources resources
COPY routes routes
COPY storage storage
COPY artisan artisan
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY .env .env

COPY ./.docker/supervisor.conf /etc/supervisor/supervisord.conf
COPY .docker/supervisor /etc/supervisor/conf.d
COPY .docker/php-config.ini "$PHP_INI_DIR/conf.d"
COPY .docker/nginx.conf /etc/nginx/nginx.conf

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN --mount=type=bind,source=composer.json,target=composer.json \
    --mount=type=bind,source=composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --no-interaction

# Create user
RUN groupadd -r $USER && useradd -ms /usr/bin/bash --no-log-init -r -g $USER $USER && \
    mkdir -p /home/$USER && \
    echo "alias ll='ls -la'" >> /home/$USER/.bashrc && echo "alias c='clear'" >> /home/$USER/.bashrc && \
    php artisan storage:link
    
# Set permission and change config
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    mkdir -p /var/run/supervisor && \
    mkdir -p /run/nginx && \
    chown -R $USER:$USER \
    /var/www/html/storage \
    /var/www/html/bootstrap \
    /var/log/supervisor \
    /var/run/supervisor \
    /run/nginx \
    /var/lib/nginx \
    /var/log/nginx

EXPOSE 8000

USER $USER:$USER

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf", "-n"]
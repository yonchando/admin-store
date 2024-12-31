FROM composer AS deps

WORKDIR /app

COPY . .

RUN --mount=type=bind,source=composer.json,target=composer.json \
    --mount=type=bind,source=composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --no-interaction


FROM dunglas/frankenphp

WORKDIR /app
 
RUN install-php-extensions \
    pcntl \
    zip \
    pdo \
    pgsql \
    pdo_pgsql 
 
COPY . /app

COPY --from=deps /app/vendor /app/vendor

RUN php artisan storage:link

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
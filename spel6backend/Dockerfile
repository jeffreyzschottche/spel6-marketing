# syntax=docker/dockerfile:1

############################
# 1) Composer deps
############################
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

############################
# 2) Runtime (nginx + php-fpm)
############################
FROM php:8.3-fpm-bookworm
WORKDIR /var/www/html

# Install nginx + deps + PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx git unzip libpq-dev libzip-dev libpng-dev libonig-dev libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip intl \
    && rm -rf /var/lib/apt/lists/*

# Nginx config
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# App source
COPY . .
COPY --from=vendor /app/vendor ./vendor

# Permissions
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Expose HTTP
EXPOSE 80

# Start both php-fpm + nginx
CMD ["bash", "-lc", "php-fpm -D && nginx -g 'daemon off;'"]

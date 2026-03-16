FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    oniguruma-dev \
    linux-headers \
    $PHPIZE_DEPS

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Redis
RUN pecl install redis && docker-php-ext-enable redis

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create user
RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app \
    && git config --global --add safe.directory /var/www/html

WORKDIR /var/www/html

# PHP config — dev by default, override via: --build-arg APP_ENV=prod
ARG APP_ENV=dev
COPY docker/php/php.${APP_ENV}.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies WITHOUT scripts
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-progress --no-interaction

# Copy project
COPY . .

# Create required Laravel directories
RUN mkdir -p bootstrap/cache storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && chown -R app:app bootstrap/cache storage

# Generate autoload after code exists (--no-scripts = не запускать artisan во время сборки)
RUN composer dump-autoload --optimize --no-scripts

USER app

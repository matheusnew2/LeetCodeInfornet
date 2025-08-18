FROM php:8.4-fpm-alpine as composer-build

WORKDIR /var/www/html/
COPY . .
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

FROM php:8.4-fpm-alpine
WORKDIR /var/www/html
# Install PHP extensions and dependencies
RUN apk --no-cache add \
    build-base \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    bash \
    fcgi \
    libmcrypt-dev \
    oniguruma-dev 

# Clear cache
RUN rm -rf /var/cache/apk/*

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath
COPY --chown=www-data:www-data . /var/www/html


COPY --from=composer-build /var/www/html/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

USER www-data
EXPOSE 9000
CMD ["php-fpm"]
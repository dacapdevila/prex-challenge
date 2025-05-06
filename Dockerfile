FROM php:8.3-cli-alpine

RUN apk add --no-cache autoconf g++ make linux-headers icu-dev zlib-dev libxml2-dev oniguruma-dev git \
 && docker-php-ext-install intl pdo_mysql mbstring xml bcmath \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && printf "xdebug.mode=coverage\nxdebug.start_with_request=no\n" \
      > /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --prefer-dist --no-interaction

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

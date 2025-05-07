FROM php:8.3-cli-alpine AS builder

RUN apk add --no-cache \
        autoconf g++ make linux-headers \
        icu-dev zlib-dev libxml2-dev oniguruma-dev git \
        nodejs npm

RUN docker-php-ext-install intl pdo_mysql mbstring xml bcmath

RUN curl -sS https://getcomposer.org/installer \
        | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

RUN composer install --prefer-dist --no-interaction

RUN npm install --no-audit --no-fund && npm run build

FROM php:8.3-cli-alpine

RUN apk add --no-cache autoconf g++ make linux-headers \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && printf "xdebug.mode=coverage\nxdebug.start_with_request=no\n" \
      > /usr/local/etc/php/conf.d/xdebug.ini \
 && apk del autoconf g++ make linux-headers

RUN apk add --no-cache icu-dev zlib-dev libxml2-dev oniguruma-dev git \
 && docker-php-ext-install intl pdo_mysql mbstring xml bcmath

WORKDIR /var/www/html

COPY --from=builder /app /var/www/html
COPY --from=builder /app/public/build /var/www/html/public/build

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

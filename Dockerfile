from wordpress:php8.0

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

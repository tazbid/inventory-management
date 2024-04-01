FROM php:8.2-fpm-bookworm as production

RUN apt update \
    && apt install -y libzip-dev libpng-dev \
    && curl -O "https://getcomposer.org/download/2.6.5/composer.phar" \
    && chmod a+x composer.phar \
    && mv composer.phar /usr/local/bin/composer \
    && docker-php-ext-install -j$(nproc) opcache pdo_mysql zip gd

FROM php:8.2-bookworm as development

RUN apt update \
    && apt install -y libzip-dev libpng-dev \
    && curl -O "https://getcomposer.org/download/2.7.2/composer.phar" \
    && chmod a+x composer.phar \
    && mv composer.phar /usr/local/bin/composer \
    && docker-php-ext-install -j$(nproc) pdo_mysql zip gd \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

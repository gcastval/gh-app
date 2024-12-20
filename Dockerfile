FROM php:8.2-fpm AS app

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install intl pdo zip

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

COPY ./composer.json ./composer.lock ./

COPY . .

RUN composer install

EXPOSE 9000

CMD ["php-fpm"]
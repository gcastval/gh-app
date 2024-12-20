FROM php:8.2-fpm AS app

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
    make \ 
    gcc \
    g++ \
    curl \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    libmariadb-dev \
    && docker-php-ext-install intl pdo zip pdo_mysql mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./composer.json ./composer.lock ./

RUN composer install --no-scripts

COPY . .

EXPOSE 9000

CMD ["php-fpm"]
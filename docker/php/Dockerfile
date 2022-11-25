FROM php:7.4-fpm

RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install zlib1g-dev -y \
        git \
        curl \
        libmcrypt-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        xvfb libfontconfig\
    && docker-php-ext-install -j$(nproc) pdo \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get update && apt-get install -y libmcrypt-dev \
    && pecl install mcrypt-1.0.4 \
    && docker-php-ext-enable mcrypt

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

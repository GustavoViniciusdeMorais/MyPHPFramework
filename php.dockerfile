FROM php:8-fpm-alpine

RUN apk update

# RUN apk add php8-common \
#     php8-fpm \
#     php8-pdo \
#     php8-opcache \
#     php8-zip \
#     php8-phar \
#     php8-iconv \
#     php8-cli \
#     php8-curl \
#     php8-openssl \
#     php8-mbstring \
#     php8-tokenizer \
#     php8-fileinfo \
#     php8-json \
#     php8-xml \
#     php8-xmlwriter \
#     php8-simplexml \
#     php8-dom \
#     php8-pdo_mysql \
#     php8-pdo_sqlite \
#     php8-tokenizer \
#     php8-pecl-redis \
#     php8-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN docker-php-ext-install pcntl

RUN apk --update add gcc make g++ zlib-dev

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev ${PHPIZE_DEPS} \
    && rm -rf /tmp/pear

RUN apk add nano
RUN apk add openrc
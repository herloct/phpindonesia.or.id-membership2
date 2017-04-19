FROM php:5.6.30-alpine

RUN apk update --no-cache

RUN apk add --no-cache  --virtual .ext-deps \
        autoconf \
        gcc \
        make \
        musl-dev \
    && pecl install --onlyreqdeps xdebug \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install \
        opcache \
        pdo_mysql

RUN apk del --no-cache --purge -r .ext-deps \
    && rm -rf /var/cache/apk/* /var/tmp/* /tmp/*

WORKDIR "/app"
VOLUME ["/app"]

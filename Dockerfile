FROM php:5.6.30-alpine

RUN apk update --no-cache 

RUN docker-php-ext-install \
        opcache \
        pdo_mysql

RUN rm -rf /var/cache/apk/* /var/tmp/* /tmp/*

WORKDIR "/app"
VOLUME ["/app"]
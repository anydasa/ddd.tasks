FROM php:7.4-fpm-alpine

RUN apk add --no-cache \
        bash \
        acl \
        icu-dev \
        postgresql-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        opcache \
        intl

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- \
      --install-dir=/usr/local/bin \
      --filename=composer

RUN curl -LS https://github.com/sensiolabs-de/deptrac/releases/download/0.10.2/deptrac.phar -o deptrac.phar \
    && chmod +x deptrac.phar \
    && mv deptrac.phar /usr/local/bin/deptrac

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-3.0.2 \
    && docker-php-ext-enable xdebug

ADD conf.ini /usr/local/etc/php/conf.d/
RUN chmod +r /usr/local/etc/php/conf.d/conf.ini

WORKDIR /app

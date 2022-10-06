FROM composer:2 AS composer
FROM php:8.1.1-fpm-alpine

ARG DOMAIN
ARG BACK_DIR
ARG ENV
ARG UID

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV BACK_DIR=${BACK_DIR}
RUN set -xe \
    && apk add --no-cache \
    $PHPIZE_DEPS \
    postgresql-client \
    ffmpeg \
    libavif-dev \
    libwebp-dev \
    libzip-dev \
    libwebp-tools \
    freetype-dev \
    libpng-dev \
    postgresql-dev \
    libjpeg-turbo-dev \
    gmp-dev \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gmp \
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) exif \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-ext-install -j$(nproc) gmp \
    && pear install pear/PHP_CodeSniffer \
    && pecl install pcov \

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN apk add --no-cache supervisor tzdata
ENV TZ Europe/Moscow

RUN if [ "$ENV" = "development" ]; \
	then pecl install xdebug && docker-php-ext-enable xdebug;  \
	else echo "$ENV"; \
	fi

COPY /php.ini /usr/local/etc/php/php.ini
COPY /fpm-pool.conf /usr/local/etc/php-fpm.d/www.conf
COPY /crontab /etc/crontabs/root

COPY /php-entrypoint.sh /etc/php-entrypoint.sh

COPY /supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN adduser -G root -u $UID -h /home/$UID -S $UID

COPY /php-entrypoint.sh /php-entrypoint.sh

RUN chmod +x /php-entrypoint.sh

#ENTRYPOINT ["sh", "/php-entrypoint.sh"]

USER $UID

CMD /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf


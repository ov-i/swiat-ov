FROM php:8.2-fpm-alpine3.17

WORKDIR /var/www

RUN apk update
RUN apk add --update --no-cache \
    alpine-sdk \
    autoconf \
    libtool \
    libzip-dev \
    zip \
    unzip \
    wget \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    mysql-client \
    mysql \
    bash \
    libxml2-dev \
    libxml2-utils \
    postfix \
    openssl \
    nodejs \
    yarn \
    libsodium-dev \
    libxslt-dev \
    linux-headers \
    sqlite-dev \
    sqlite-libs \
    sqlite \
    man-pages \
    ca-certificates

RUN docker-php-ext-configure zip
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    gd -j $(nproc) \
    pdo_sqlite \
    pdo_mysql \
    zip \
    bcmath \
    mbstring \
    xsl \
    exif \
    opcache \
    pcntl \
    sodium

RUN pecl install redis
RUN pecl install xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN addgroup -g 1000 www
RUN adduser -D -u 1000 -G www www

COPY . .

RUN chown -R www:www /var/www

RUN update-ca-certificates

USER www

RUN composer install

CMD ["php-fpm"]

EXPOSE 9000

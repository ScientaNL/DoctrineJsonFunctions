FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
        libpq-dev \
        libzip-dev \
        unzip \
        git \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \
        zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

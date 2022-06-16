FROM composer:1 AS composer
FROM php:7.4-fpm-buster

ENV DEBIAN_FRONTEND=noninteractive

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    libzip-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libonig-dev \
    locales \
    zip \
    vim \
    unzip \
    git \
    redis-tools \
    curl \
    iproute2 \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /var/cache/apt/*

# Install extensions
RUN pecl install redis \
    && docker-php-ext-configure gd --with-jpeg=/usr/include --with-freetype=/usr/include \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install \
    mbstring \
    pdo_mysql \
    zip \
    exif \
    pcntl \
    gd \
    opcache \
    && docker-php-ext-enable redis \
    && rm -rf /usr/src

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www/

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer global require hirak/prestissimo \
    && cd /var/www \
    && composer install \
    && composer dump-autoload -o

RUN chown -R www:www /var/www \
     && cd /var/www/public

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

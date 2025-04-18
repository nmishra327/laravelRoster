FROM php:8.2-fpm

# Install system dependencies including netcat (correct name: netcat-openbsd)
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip unzip curl git \
    netcat-openbsd \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .
RUN composer install

RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]

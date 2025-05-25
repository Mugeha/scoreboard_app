# Use official PHP image with Apache
FROM php:8.2-apache

# Install required extensions (e.g. MySQL) and Git
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all app files into container's web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install PHP dependencies
RUN composer install --no-interaction --no-dev --prefer-dist

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

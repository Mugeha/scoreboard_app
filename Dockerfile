# Use official PHP image with Apache
FROM php:8.2-apache

# Install required extensions (e.g. MySQL)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy all app files into container's web root
COPY . /var/www/html/

# Set permissions (optional, avoids EACCES issues)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

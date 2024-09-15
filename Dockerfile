# Use the official Alpine-based PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt update && apache2 curl gnupg ca-certificates zip unzip git supervisor libpng-dev libjpeg librsvg \
php php-xmlreader php-mysqli php-zip php-apache2 php-cli php-dev php-pdo_pgsql php-gd php-curl php-xml php-mbstring \
php-openssl php-json php-dom php-ctype php-session php-fileinfo php-xmlwriter php-simplexml php-tokenizer php-pdo_mysql php-phar \
    && docker-php-ext-enable xdebug \
    && apt del .build-deps

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite && systemctl restart apache2

# Set the working directory
WORKDIR /var/www/html/test

# Copy existing application directory contents
COPY . /var/www/html/test

# Set the appropriate permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/test \
    && chmod -R 755 /var/www/html/test

# Expose port 80
#EXPOSE 80

# Start Apache in the foreground
#CMD ["apache2-foreground"]

# Expose the port on which PHP-FPM will listen
EXPOSE 9000

# Start PHP-FPM server
#CMD ["php-fpm"]
# Command to run (e.g., start PHP built-in server, if applicable)
CMD ["php", "-S", "0.0.0.0:9000"]






# Use the official Alpine-based PHP image with Apache
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-install zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


  

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
#RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html/test

# Copy existing application directory contents
COPY . /var/www/html/test

# Set the appropriate permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/test \
    && chmod -R 777 /var/www/html/test

#RUN apt-get update && apt-get install -y \
 #   && a2enmod mpm_prefork && a2enmod php  
    

# Expose port 80
#EXPOSE 80

# Start Apache in the foreground
#CMD ["apache2-foreground"]

# Expose the port on which PHP-FPM will listen
EXPOSE 8000

# Start PHP-FPM server
#CMD ["php-fpm"]
# Command to run (e.g., start PHP built-in server, if applicable)
CMD ["php-fpm", "0.0.0.0:8000"]






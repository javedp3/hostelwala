
FROM php:8.3-cli

# Install system dependencies and PHP extensions
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

# Install Composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# Copy custom PHP configuration
#COPY ./php.ini /usr/local/etc/php/

# Copy the application code and Composer files
#COPY ./src /var/www/html/
#COPY ./composer.json /var/www/html/test
#COPY ./composer.lock /var/www/html/test

# Set the working directory
WORKDIR /var/www/html/test

## Copy Composer files (composer.json and composer.lock) if they exist
#COPY composer.json composer.lock* /var/www/html/test
# Install PHP dependencies via Composer

RUN php artisan cache:clear &&  php artisan config:clear \
                    && php artisan config:cache
                    
RUN composer --version

# Expose the port on which PHP-FPM will listen
EXPOSE 9000

# Start PHP-FPM server
#CMD ["php-fpm"]
# Command to run (e.g., start PHP built-in server, if applicable)
CMD ["php", "-S", "0.0.0.0:9000"]

# Use the official PHP image with Apache
FROM php:8.1-apache

# Install necessary system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring

# Enable Apache mod_rewrite for Laravel
RUN a2enmod rewrite

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the Laravel project files into the container
COPY . .

# Install composer and PHP dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions for Laravel directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ensure the storage and bootstrap/cache directories are writable
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy the existing environment file, if needed
# COPY .env.example .env

# Generate application key (this should be set securely during deployment)
RUN php artisan key:generate

# Expose port 80 for Apache
EXPOSE 80

# Start the Apache server in the foreground
CMD ["apache2-foreground"]

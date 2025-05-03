FROM php:8.2-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
  git \
  curl \
  unzip \
  libpq-dev \
  libzip-dev \
  zip \
  && docker-php-ext-install pdo pdo_pgsql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy files and install dependencies
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose web port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

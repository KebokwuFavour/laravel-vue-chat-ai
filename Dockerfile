# Use official PHP with Apache image
FROM php:8.2-apache

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
  git \
  curl \
  unzip \
  zip \
  libpq-dev \
  libzip-dev \
  nodejs \
  npm \
  && docker-php-ext-install pdo pdo_pgsql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Tell Apache to serve from /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Grant permissions to /public
RUN echo '<Directory /var/www/html/public>\n\
  AllowOverride All\n\
  Require all granted\n\
  </Directory>' >> /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build frontend
RUN npm install && npm run build

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose Apache port
EXPOSE 80

# Run migrations and start Apache
CMD php artisan migrate --force && apache2-foreground

# -------------------------------
# Base PHP + Apache image
# -------------------------------
FROM php:8.2-apache

# -------------------------------
# Install system dependencies
# -------------------------------
RUN apt-get update && apt-get install -y \
        libssl-dev \
        pkg-config \
        libcurl4-openssl-dev \
        libpng-dev \
        libonig-dev \
        unzip \
        git \
        curl \
        zip \
        libzip-dev \
        nodejs \
        npm \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# -------------------------------
# Set working directory
# -------------------------------
WORKDIR /var/www/html

# -------------------------------
# Copy composer binary from composer image
# -------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -------------------------------
# Copy all project files
# -------------------------------
COPY . .

# -------------------------------
# Install Node.js dependencies
# -------------------------------
RUN npm install

# -------------------------------
# Build frontend assets for production
# -------------------------------
RUN npm run build

# -------------------------------
# Install PHP dependencies (skip scripts during build)
# -------------------------------
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts

# -------------------------------
# Fix permissions for Laravel
# -------------------------------
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# -------------------------------
# Update Apache config to serve /public
# -------------------------------
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# -------------------------------
# Expose port 80 for Railway
# -------------------------------
EXPOSE 80

# -------------------------------
# Run Laravel setup + Apache
# -------------------------------
CMD php artisan migrate --force && \
    php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    apache2-foreground

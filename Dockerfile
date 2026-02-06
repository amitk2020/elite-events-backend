FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project files
COPY . .

# Install dependencies WITHOUT running Symfony scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Expose Render port
EXPOSE 10000

# Start Symfony
CMD php -S 0.0.0.0:10000 -t public
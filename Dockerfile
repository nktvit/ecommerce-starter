# Frontend Dockerfile
# ...

# Backend Dockerfile
# ...

# Global Dockerfile
# Use the official PHP 7.4 image as the base for the backend
FROM --platform=linux/amd64 php:8.1-fpm as backend

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the backend files to the container
COPY . .

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    && docker-php-ext-install pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install backend dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Expose the port that the backend will run on
EXPOSE 8000

# Start the Laravel backend
CMD php artisan serve --host=0.0.0.0 --port=8000

# Use PHP 8.2 with Apache as the base image
FROM php:8.2-apache

# Install essential PHP extensions for MySQL and PDO support
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install dependencies and configure PHP extensions for image manipulation (GD) and zip support
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install mysqli pdo pdo_mysql gd zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Install Composer globally for managing PHP dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the application files into the container
COPY . /var/www/html/

# Install production dependencies via Composer with optimizations
RUN composer install --no-dev --optimize-autoloader

# Expose Apache port 80 for web access
EXPOSE 80

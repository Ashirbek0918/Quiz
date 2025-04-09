FROM php:8.2-fpm

ARG user=laravel
ARG uid=1000

# System packages
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    --no-install-recommends \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel project files
COPY . /var/www/

# Copy php.ini config
COPY docker/php/php.ini $PHP_INI_DIR/

# Set working directory
WORKDIR /var/www

# Create user
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-req=ext-gd



# Create .env file
RUN cp .env.example .env

# Set permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www/storage

# Generate app key
RUN php artisan key:generate

# Switch to new user
USER $user

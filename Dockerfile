FROM php:8.2-fpm

# Update and install necessary packages
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip intl mbstring exif pcntl bcmath gd sockets
RUN docker-php-ext-enable pdo_mysql zip intl mbstring exif pcntl bcmath gd sockets

WORKDIR /app
# Copy existing application directory contents
COPY . /app

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=ghcr.io/roadrunner-server/roadrunner:latest /usr/bin/rr /usr/local/bin/rr

ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 8000

CMD bash -c "composer install && php artisan octane:install --server=roadrunner && php artisan octane:start --server=roadrunner --host=0.0.0.0 --port=8000"

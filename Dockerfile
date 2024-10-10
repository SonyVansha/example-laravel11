# Gunakan image resmi PHP 8.x dengan ekstensi yang dibutuhkan
FROM php:8.1-fpm

# Set environment variable
ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    npm \
    nodejs \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Salin file composer.json dan composer.lock, kemudian install dependensi PHP
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version
RUN composer install --no-scripts --no-autoloader
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Salin semua file source code ke dalam container
COPY . .

# Install autoload dan cache konfigurasi Laravel
RUN composer dump-autoload && php artisan config:cache

# Install dependensi Node.js dan Tailwind CSS
RUN npm install && npm run build

# Ubah izin direktori storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 9000 (untuk PHP-FPM)
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]

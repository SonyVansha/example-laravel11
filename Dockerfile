# Gunakan PHP image yang sesuai
FROM php:8.1-fpm

# Install ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Ubah ke direktori kerja
WORKDIR /var/www

# Salin file composer.json dan composer.lock, kemudian install dependensi PHP
COPY composer.json composer.lock ./

# Diagnosa potensi masalah
RUN composer diagnose

# Install dependensi Composer
RUN composer install --prefer-dist --no-dev --optimize-autoloader

# Salin semua file source code ke dalam container
COPY . .

# Pastikan izin yang benar untuk file
RUN chown -R www-data:www-data /var/www

# Expose port 9000 (untuk PHP-FPM)
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]

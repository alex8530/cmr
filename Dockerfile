# Use the official PHP image with version 8.2 as the base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
#RUN apt-get update && apt-get install -y \
#    nginx \
#    libpng-dev \
#    libjpeg62-turbo-dev \
#    libfreetype6-dev \
#    locales \
#    zip \
#    jpegoptim optipng pngquant gifsicle \
#    vim \
#    unzip \
#    git \
#    curl \
#    libonig-dev \
#    libzip-dev \
#    telnet \
#    && docker-php-ext-configure gd --with-freetype --with-jpeg \
#    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel application files
COPY . /var/www/html


# Install Laravel dependencies
#RUN composer install --no-dev --optimize-autoloader


<<<<<<< HEAD
# Set permissions for Laravel directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN find /var/www/html/storage -type d -exec chmod 775 {} \;
RUN find /var/www/html/storage -type f -exec chmod 664 {} \;
RUN find /var/www/html/bootstrap/cache -type d -exec chmod 775 {} \;
RUN find /var/www/html/bootstrap/cache -type f -exec chmod 664 {} \;

# Copy Nginx configuration file
#COPY nginx.conf /etc/nginx/sites-available/default
=======
##RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache
>>>>>>> 348394cda89954176071fdfecacbdf772259e18a


# Expose port 9002
EXPOSE 9000

# Start PHP-FPM and Nginx
CMD ["sh", "-c", " php-fpm  && nginx -g 'daemon off;'"]

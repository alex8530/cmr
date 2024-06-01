# Use the official PHP image with version 8.2 as the base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    telnet \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel application files
COPY . /var/www/html


# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
#RUN chown -R www-data:www-data   /var/www/html/bootstrap/cache
# Set correct permissions

##RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

# Remove default Nginx configuration
#RUN rm /etc/nginx/sites-available/default

# Copy Nginx configuration file
COPY nginx.conf /etc/nginx/sites-available/default





# Expose port 9002
EXPOSE 9000

# Start PHP-FPM and Nginx
CMD ["sh", "-c", " php-fpm  && nginx -g 'daemon off;'"]

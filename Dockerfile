# Use an official PHP image as the base image
FROM php:8.1-apache

# Set the working directory
WORKDIR /var/www/html

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

# Copy the application code to the container
COPY . /var/www/html

# Set permissions for the application
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/front_office|' /etc/apache2/sites-available/000-default.conf
RUN ln -s /var/www/html/public/images /var/www/html/front_office/images
RUN ln -s /var/www/html/public/images /var/www/html/back_office/images
RUN ln -s /var/www/html/back_office /var/www/html/front_office/back_office
#RUN ln -s /var/www/html/front_office /var/www/html/back_office/front_office
# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]

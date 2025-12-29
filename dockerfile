# Base image PHP + Apache
FROM php:8.2-apache

# Enable Apache rewrite (opsional tapi sering kepake)
RUN a2enmod rewrite

# Set document root ke folder project
WORKDIR /var/www/html

# Copy semua file project ke container
COPY . /var/www/html/

# Set permission (penting untuk upload folder)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

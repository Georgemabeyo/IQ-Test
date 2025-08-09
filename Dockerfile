# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Copy all project files to the Apache web root
COPY . /var/www/html/

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache in the foreground (default command)
CMD ["apache2-foreground"]

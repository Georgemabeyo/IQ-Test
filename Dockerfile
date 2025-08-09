FROM php:8.2-apache

# Install mysqli extension and other dependencies if needed
RUN docker-php-ext-install mysqli

COPY . /var/www/html/

EXPOSE 80

CMD ["apache2-foreground"]

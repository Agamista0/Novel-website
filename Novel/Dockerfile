FROM php:apache 

COPY . /var/www/html


RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli 
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get upgrade -y git
RUN pecl install redis && docker-php-ext-enable redis
RUN a2enmod  rewrite



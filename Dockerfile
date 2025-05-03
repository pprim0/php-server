FROM php:8.1-apache

# Instala mysqli e outras dependências
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libonig-dev libxml2-dev zip unzip && docker-php-ext-install mysqli

# Copia os ficheiros PHP
WORKDIR /var/www/html
COPY . .

# Exposição da porta default do Apache (80)
EXPOSE 80

FROM php:8.1-cli

# Instala mysqli
RUN apt-get update && apt-get install -y php-mysqli

# Copia os ficheiros PHP
WORKDIR /var/www/html
COPY . .

# Inicia o servidor web embutido
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/var/www/html"]



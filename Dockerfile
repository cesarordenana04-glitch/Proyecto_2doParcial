# 1. Usar una imagen oficial de PHP con Apache
FROM php:8.2-apache

# 2. Habilitar el módulo rewrite para que tu archivo .htaccess funcione
RUN a2enmod rewrite

# 3. Instalar las herramientas para conectarse a bases de datos MySQL
RUN docker-php-ext-install pdo pdo_mysql

# 4. Copiar todo el código de tu proyecto a la carpeta pública del servidor
COPY . /var/www/html/
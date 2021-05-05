FROM php:7.4-apache

EXPOSE 80
WORKDIR /my-hobbies

# Install some base tools
RUN apt-get update -qq && \
    apt-get install -qy \
    zip \
    libzip-dev \
    npm

# ext-zip is for Laravel
RUN docker-php-ext-install zip

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Install Laravel
RUN composer global require laravel/installer

# Enable mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# Site will be in `/my-hobbies/public` instead of `/var/www/html`
COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY conf/apache.conf /etc/apache2/conf-available/z-app.conf
RUN a2enconf z-app

# PDO MySQL extension
RUN docker-php-ext-install -j$(nproc) pdo_mysql

# php.ini
COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini

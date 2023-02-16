FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo_mysql 

RUN apk add --no-cache nginx supervisor

WORKDIR /var/www/html

COPY . .

#RUN chown -R www-data:www-data var


WORKDIR /var/www/html/server

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install

#migrations
#RUN php bin/console doctrine:migrations:migrate --no-interaction
#RUN php bin/console doctrine:fixtures:load --no-interaction
#RUN php -S localhost:8080 -t public/

# Start PHP server
#CMD ["php", "bin/console", "server:run", "0.0.0.0:8080"]

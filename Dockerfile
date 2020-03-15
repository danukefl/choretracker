FROM php:7.2-apache
MAINTAINER Danuke

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY source /var/www/html/

ENV DB_HOST 127.0.0.1
ENV DB_NAME default_db
ENV DB_USER default_user
ENV DB_PASS default_password


EXPOSE 80

CMD ["apache2-foreground"]

ENTRYPOINT ["docker-php-entrypoint"]


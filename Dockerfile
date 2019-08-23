FROM php:7-apache

COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html

ENV DB_SERVER db-server
ENV DB_DB db
ENV DB_USER db-user
ENV DB_PASSWORD db-pass

RUN apt-get update -y && \
    apt-get install -y \
        wget \
    docker-php-ext-install \
        mbstring \
        zip \
        gd \
        mysqli \
        pdo \
        pdo_mysql \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && cd /var/www/html
    && wget https://getcomposer.org/composer.phar
    && php composer.phar install
    && echo "<?php return ['class' => 'yii\db\Connection','dsn' => 'mysql:host=$DB_SERVER;dbname=$DB_DB','username' => '$DB_USER','password' => '$DB_PASSWORD','charset' => 'utf8']; ?>" > config/db.php
    && php yii migrate
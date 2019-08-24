FROM php:7-apache

COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/entrypoint.sh /var/www/html/entrypoint.sh
COPY . /var/www/html


ENV DB_SERVER db-server
ENV DB_DB db
ENV DB_USER db-user
ENV DB_PASSWORD db-pass

RUN apt-get update -y && \
    apt-get install -y \
        wget \
        zlib1g-dev \
        libzip-dev  \
        imagemagick \
        libmagickwand-dev \
    && docker-php-ext-install \
        mbstring \
        zip \
        mysqli \
        pdo \
        pdo_mysql \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && cd /var/www/html \
    && chmod 0777 entrypoint.sh \
    && rm web/.htaccess \
    && chmod 777 /var/www/html/web/assets \
    && echo "<?php return ['class' => 'yii\db\Connection','dsn' => 'mysql:host='.getenv('DB_SERVER').';dbname='.getenv('DB_DB'),'username' => getenv('DB_USER'),'password' => getenv('DB_PASSWORD'),'charset' => 'utf8']; ?>" > config/db.php \
    && wget https://getcomposer.org/composer.phar \
    && php composer.phar install

ENTRYPOINT ["/var/www/html/entrypoint.sh"]

EXPOSE 80/tcp

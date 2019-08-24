#!/bin/bash
cd /var/www/html/
{ \
    echo "<?php"; \
    echo "return ["; \
    echo "    'class' => 'yii\db\Connection',"; \
    echo "    'dsn' => 'mysql:host=$DB_SERVER;dbname=$DB_DB',"; \
    echo "    'username' => '$DB_USER',"; \
    echo "    'password' => '$DB_PASSWORD',"; \
    echo "    'charset' => 'utf8',"; \
    echo "];"; \
} > ./config/db.php
chmod 777 -R ./web/assets
chmod 777 -R ./web/import
rm ./web/.htaccess
php yii migrate --interactive=0 > /dev/null
apache2-foreground
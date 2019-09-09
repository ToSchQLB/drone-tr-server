<?php

$time = time();

return [
    'test.admin'  => [
        'id'            => 1,
        'username'      => 'test.admin',
        'email'         => 'test.admin@test.de',
        'password_hash' => Yii::$app->security->generatePasswordHash('password'),
        'auth_key'      => 'abcd1234',
        'flags'         => 0,
        'confirmed_at'  => $time,
        'updated_at'    => $time,
        'last_login_at' => $time,
        'first_name'    => 'Test',
        'last_name'     => 'Admin',
        'extern'        => 1,
    ],
    'test.nutzer' => [
        'id'            => 2,
        'username'      => 'test.nutzer',
        'email'         => 'test.nutzer@test.de',
        'password_hash' => Yii::$app->security->generatePasswordHash('password'),
        'auth_key'      => '1234abcd',
        'flags'         => 0,
        'confirmed_at'  => $time,
        'updated_at'    => $time,
        'last_login_at' => $time,
        'first_name'    => 'Test',
        'last_name'     => 'Nutzer',
        'extern'        => 1,
    ],
];
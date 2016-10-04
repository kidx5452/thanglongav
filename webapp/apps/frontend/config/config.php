<?php
    ini_set('display_errors', 'On');
    error_reporting(1);
    return new \Phalcon\Config([
        'database' => [
            'adapter' => 'Mysql',
            'host' => 'localhost',
            'username' => 'thanglonga_demo',
            'password' => 'demo',

/*            'port' => '3306',
            'username'    => 'root',
            'password'    => '12345',*/

            'dbname' => 'thanglonga_demo',
            'charset' => 'utf8',
        ],
        'application' => [
            'controllersDir' => __DIR__ . '/../controllers/',
            'modelsDir' => __DIR__ . '/../models/',
            'migrationsDir' => __DIR__ . '/../migrations/',
            'viewsDir' => __DIR__ . '/../views/',
            'pluginsDir' => __DIR__ . '/../plugins/',
            'libraryDir' => __DIR__ . '/../library/',
            'cacheDir' => __DIR__ . '/../cache/',
            'vendorDir' => __DIR__ . '/../vendor/',
            'cultureDir' => __DIR__ . '/../config/i18n/',
            'baseUri' => '/backend',
            'baseUrl' => 'http://thanglongav.vn/',
            'rpRequestLogLimit' => 90
            // so ngay luu tru bao cao truy cap
        ],
        "media" => [
            'dir' => '/home/thanglonga/domains/thanglongav.vn/public_html/public',
            "host" => "http://thanglongav.vn/"
        ]
    ]);

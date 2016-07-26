<?php
return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '123456$',
        'dbname'      => 'iii',
        'charset'     => 'utf8',
    ),
    'application' => array(
        'controllersDir' => __DIR__  . '/../controllers/',
        'modelsDir'      => __DIR__ . '/../models/',
        'migrationsDir'  => __DIR__ . '/../migrations/',
        'viewsDir'       => __DIR__ . '/../views/',
        'pluginsDir'     => __DIR__ . '/../plugins/',
        'libraryDir'     => __DIR__ . '/../library/',
        'cacheDir'       => __DIR__ . '/../cache/',
        'vendorDir'       => __DIR__ . '/../vendor/',
        'cultureDir'       => __DIR__ . '/../config/i18n/',
        'baseUri'        => '/backend',
        'baseUrl' => 'http://wsi.vn/',
        'rpRequestLogLimit' => 90 // so ngay luu tru bao cao truy cap
    ),
    "media"=>array(
        'dir'=>'/home/wsi.vn/public_html/public/',
        "host"=>"http://wsi.vn/"
    )
));
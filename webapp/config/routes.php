<?php

$router = $di->get("router");

foreach ($application->getModules() as $key => $module) {
    $namespace = str_replace('Module','Controllers', $module["className"]);
    $router->add('/'.$key.'/:params', array(
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 'index',
        'action' => 'index',
        'params' => 1
    ))->setName($key);
    $router->add('/'.$key.'/:controller/:params', array(
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 1,
        'action' => 'index',
        'params' => 2
    ));
    $router->add('/'.$key.'/:controller/:action/:params', array(
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ));
    //Category
    $router->add('/{slug}_c{id:[0-9]+}.html', array(
        'controller' => 'category',
        'action' => 'index',
        'id' => 1, // ([0-9]+)
    ));
    //Category
    $router->add('/{slug}_cd{id:[0-9]+}.html', array(
        'controller' => 'category',
        'action' => 'detail',
        'id' => 1, // ([0-9]+)
    ));

    //Article
    $router->add('/{slug}_a{id:[0-9]+}.html', array(
        'controller' => 'article',
        'action' => 'detail',
        'id' => 1, // ([0-9]+)
    ));
}

$di->set("router", $router);

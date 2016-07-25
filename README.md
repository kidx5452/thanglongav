-- Add module
1. phalcon module --name=backend --namespace=Webapp\Backend --output=apps
2. Add to services.php
$router->add("/backend", array(
        'module'     => 'backend',
        'namespace'  => 'Webapp\Backend\Controllers',
        'controller' => 'index',
        'action'     => 'index',
    ));
3. Add to modules.php
'backend' => array(
        'className' => 'Webapp\Backend\Module',
        'path' => __DIR__ . '/../apps/backend/Module.php'
    )

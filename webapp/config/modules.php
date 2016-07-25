<?php

/**
 * Register application modules
 */
$application->registerModules(array(
    'frontend' => array(
        'className' => 'Webapp\Frontend\Module',
        'path' => __DIR__ . '/../apps/frontend/Module.php'
    ),
    'backend' => array(
        'className' => 'Webapp\Backend\Module',
        'path' => __DIR__ . '/../apps/backend/Module.php'
    )
));

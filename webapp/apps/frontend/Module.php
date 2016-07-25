<?php

namespace Webapp\Frontend;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Config;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {

        $loader = new Loader();

        $loader->registerNamespaces(array(
            'Webapp\Frontend\Controllers' => __DIR__ . '/controllers/',
            'Webapp\Frontend\Models' => __DIR__ . '/models/',
        ));

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * Read common configuration
         */
        $config = $di->has('config') ? $di->getShared('config') : null;

        /**
         * Try to load local configuration
         */
        if (file_exists(__DIR__ . '/config/config.php')) {
            $override = new Config(include __DIR__ . '/config/config.php');;

            if ($config instanceof Config) {
                $config->merge($override);
            } else {
                $config = $override;
            }
        }

        /**
         * Setting up the view component
         */
        $di['view'] = function () use ($config) {
            $view = new View();
            $view->setViewsDir($config->get('application')->viewsDir);
            $view->registerEngines(array(
                '.volt' => function ($view, $di) use ($config) {

                    $volt = new VoltEngine($view, $di);

                    $volt->setOptions(array(
                        'compiledPath' => $config->application->cacheDir,
                        'compiledSeparator' => '_',
                        'stat' => true,
                        'compileAlways' => true
                    ));
                    //load function php
                    $compiler = $volt->getCompiler();
                    //define variable translate
                    $compiler->addFunction('in_array', 'in_array');
                    $compiler->addFunction('number_format','number_format');
                    $compiler->addFunction('str_replace', 'str_replace');
                    $compiler->addFunction(
                        'checkperrmission',
                        function ($resolvedArgs, $exprArgs) {
                            return 'Module::is_accept_permission(' . $resolvedArgs . ')';
                        }
                    );


                    return $volt;
                },
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
            ));
            return $view;
        };

        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di['db'] = function () use ($config) {
            $config = $config->database->toArray();

            $dbAdapter = '\Phalcon\Db\Adapter\Pdo\\' . $config['adapter'];
            unset($config['adapter']);

            return new $dbAdapter($config);
        };
    }
}

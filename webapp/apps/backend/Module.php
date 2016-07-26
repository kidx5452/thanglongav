<?php

namespace Webapp\Backend;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Config;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

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
            'Webapp\Backend\Controllers' => __DIR__ . '/controllers/',
            'Webapp\Backend\Models'      => __DIR__ . '/models/',
            'Webapp\Backend\Locale'      => __DIR__ . '/config/i18n/',
            'Webapp\Backend\Utility'      => __DIR__ . '/library/',
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
         * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
         */
        //$di = new FactoryDefault();

        /**
         * The URL component is used to generate all kind of urls in the application
         */
        $di->setShared('url', function () use ($config) {
            $url = new Url();
            $url->setBaseUri($config->application->baseUri);

            return $url;
        });
        $di->set('config', function () use ($config) {
            return $config;
        }, true);
        $di->set('cookies', function () {
            $cookies = new \Phalcon\Http\Response\Cookies();
            $cookies->useEncryption(false);

            return $cookies;
        });
        /**
         * Setting up the view component
         */
        $di->setShared('view', function () use ($config) {

            $view = new View();

            $view->setViewsDir($config->application->viewsDir);

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
                            return '\Webapp\Backend\Utility\Module::is_accept_permission(' . $resolvedArgs . ')';
                        }
                    );


                    return $volt;
                },
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
            ));

            return $view;
        });

        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di->setShared('db', function () use ($config) {
            $dbConfig = $config->database->toArray();
            $adapter = $dbConfig['adapter'];
            unset($dbConfig['adapter']);

            $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

            return new $class($dbConfig);
        });

        /**
         * If the configuration specify the use of metadata adapter use it or use memory otherwise
         */
        $di->setShared('modelsMetadata', function () {
            return new MetaDataAdapter();
        });

        /**
         * Register the session flash service with the Twitter Bootstrap classes
         */
        $di->set('flash', function () {
            $flash = new \Phalcon\Flash\Session([
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice' => 'alert alert-info',
            ]);

            return $flash;
        });

        /**
         * Start the session the first time some component request the session service
         */
        $di->setShared('session', function () {
            $session = new SessionAdapter();
            $session->start();

            return $session;
        });




    }
}

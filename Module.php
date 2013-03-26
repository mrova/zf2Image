<?php
// $

namespace zf2Image;


use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        //return include __DIR__ . '/config/module.config.php';


        $data_config = include __DIR__ . '/config/module.config.php';
        $config = new \Zend\Config\Config($data_config, true);

        if(\file_exists('data/zf2imagestyles.ini')){
            $reader = new \Zend\Config\Reader\Ini();
            $data   = $reader->fromFile('data/zf2imagestyles.ini');
            $config2 = new \Zend\Config\Config($data, true);
            $config->merge($config2);
        }
        else{
            $data_config = include __DIR__ . '/config/image_styles.config.php';
            $config2 = new \Zend\Config\Config($data_config, true);
            $config->merge($config2);
        }

        return $config;

    }


    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'ImageService' => function($sm) {
                      return new \zf2Image\Service\Image();

                },
            ),
        );
    }


     public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'zf2Image' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\Image;
                    $viewHelper->setLocator($locator);
                    return $viewHelper;
                },
            ),
        );
    }

    public function onBootstrap($e)
    {

    }

}
<?php
// module/User/Module.php
namespace Image;

// Add this import statement:



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
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     *
     * @return multitype:multitype:NULL  |\User\Model\UserTable
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
//                'User\Model\UserTable' =>  function($sm) {
//                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//                    $table     = new UserTable($dbAdapter);
//                    return $table;
//                },
//
//                'User\Auth\Storage\Storage' => function($sm){
//                    return new \User\Auth\Storage\Storage();
//                },
                'ImageService' => function($sm) {
                      return new \Image\Service\Image();
//                    $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
//                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter,
//                        'user',
//                        'username',
//                        'password',
//                        'MD5(?) AND status = 1');
//                    $authService = new AuthenticationService();
//                    $authService->setAdapter($dbTableAuthAdapter);
//                    $authService->setStorage($sm->get('User\Auth\Storage\Storage'));
//                    return $authService;
                },


            ),
        );
    }


     public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'Image' => function ($sm) {
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

//        $app = $e->getApplication();
//        $eventManager  = $app->getEventManager()->getSharedManager();
//
//        $eventManager->attach('*', 'dotestevent', function($evn){
//            $event = $evn->getName();
//            $params = $evn->getParams();
//            printf(
//            'Handles event "%s", with parameters %s',
//            $event,
//            json_encode($params)
//            );
//        });




    }

//    public function checkACL($e)
//    {
//        /* $routeMatch = $e->getRouteMatch();
//        if (!$routeMatch) {
//            return;
//        }
//        $app     = $e->getApplication();
//        $locator = $app->getServiceManager();
//        $auth    = $locator->get('ControllerPluginManager')->get('Permission')->doAuthorization($e, $locator); */
//        echo 'check ACL!!!!!';
//    }

}
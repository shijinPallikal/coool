<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Service;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Service\Model\ServiceHistoryModel;
use Service\Model\ServiceHistoryTable;
use Service\Model\PhoneModel;
use Service\Model\PhoneTable;
use Service\Model\EmailModel;
use Service\Model\EmailTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    //Service History Table
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Service\Model\ServiceHistoryTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ServiceHistoryTable($dbAdapter);
                    return $table;
                },
      

                //Email Table
                'Service\Model\EmailTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new EmailTable($dbAdapter);
                    return $table;
                },
      

                //Phone Table
     
                'Service\Model\PhoneTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new PhoneTable($dbAdapter);
                    return $table;
                },
     
    /*public function getServiceConfig()
    {
        return array(                           
            'factories' => array(   
                'Service\Model\ServiceHistoryTable' =>  function($sm)
                    {                     
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $table = new ServiceHistoryTable($dbAdapter);
                        return $table;                                      
                    }
            )
        )
    }*/

          ),
        );
    }
}

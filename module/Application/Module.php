<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Admin\Model\SliderModel;
use Admin\Model\SliderTable;

use Admin\Model\SmallPackageModel;
use Admin\Model\SmallPackageTable;

use Admin\Model\BigPackageModel;
use Admin\Model\BigPackageTable;

use Admin\Model\OfferDatesTable;
use Admin\Model\OfferDatesModel;

use Admin\Model\MenuTable;
use Admin\Model\MenuModel;

use Admin\Model\UserContactsTable;
use Admin\Model\UserContactsModel;

use Admin\Model\LogoTable;
use Admin\Model\LogoModel;

use Admin\Model\OtherServicesModel;
use Admin\Model\OtherServicesTable;

use Admin\Model\ColorTable;
use Admin\Model\ColorModel;

use Admin\Model\SliderColorTable;
use Admin\Model\SliderColorModel;

use Admin\Model\PagesTable;
use Admin\Model\PagesModel;

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
                'Admin\Model\SliderTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new SliderTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\SmallPackageTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new SmallPackageTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\BigPackageTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new BigPackageTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\OfferDatesTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new OfferDatesTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\MenuTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new MenuTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\LogoTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new LogoTable($dbAdapter);
                    return $table;
                },
                
                'Admin\Model\OtherServicesTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new OtherServicesTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\ColorTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ColorTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\SliderColorTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new SliderColorTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\PagesTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new PagesTable($dbAdapter);
                    return $table;
                },

            ),
        );
    }

}


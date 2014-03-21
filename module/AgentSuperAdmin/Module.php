<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonAgentSuperAdmin for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace AgentSuperAdmin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;


use Admin\Model\LoginModel;
use Admin\Model\LoginTable;

use Admin\Model\LogoModel;
use Admin\Model\LogoTable;


use Admin\Model\SmallPackageModel;
use Admin\Model\SmallPackageTable;

use Admin\Model\OfferDatesTable;
use Admin\Model\OfferDatesModel;

use Admin\Model\LanguagesTable;
use Admin\Model\LanguagesModel;

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

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Admin\Model\LoginTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new LoginTable($dbAdapter);
                    return $table;
                },

                'AgentSuperAdminAuth' => function($sm)
                {
                    $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');     
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 'login','username','password', 'MD5(?)');
                    $authService = new AuthenticationService();     
                    $authService->setAdapter($dbTableAuthAdapter);      
                    return $authService;
                },

                'Admin\Model\SmallPackageTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new SmallPackageTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\OfferDatesTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new OfferDatesTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\LogoTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new LogoTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\LanguagesTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new LanguagesTable($dbAdapter);
                    return $table;
                },
            ),
        );
    }
}

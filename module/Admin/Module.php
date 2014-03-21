<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;
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

use Admin\Model\SliderModel;
use Admin\Model\SliderTable;

use Admin\Model\MenuTable;
use Admin\Model\MenuModel;

use Admin\Model\CountryTable;
use Admin\Model\CountryModel;

use Admin\Model\SmallPackageTable;
use Admin\Model\SmallPackageModel;

use Admin\Model\BigPackageTable;
use Admin\Model\BigPackageModel;

use Admin\Model\EcommercePackageTable;
use Admin\Model\EcommercePackageModel;

use Admin\Model\OfferDatesTable;
use Admin\Model\OfferDatesModel;


use Admin\Model\WebPackageModel;
use Admin\Model\WebPackageTable;

use Admin\Model\WebPackageSpecificationModel;
use Admin\Model\WebPackageSpecificationTable;

use Admin\Model\EmailTable;
use Admin\Model\EmailModel;

use Admin\Model\PhoneTable;
use Admin\Model\PhoneModel;

use Admin\Model\ContactsTable;
use Admin\Model\ContactsModel;

use Admin\Model\UserEmailTable;
use Admin\Model\UserEmailModel;

use Admin\Model\LogoTable;
use Admin\Model\LogoModel;

use Admin\Model\OtherServicesModel;
use Admin\Model\OtherServicesTable;

use Admin\Model\ServiceTemplateModel;
use Admin\Model\ServiceTemplateTable;

use Admin\Model\ServicePagesModel;
use Admin\Model\ServicePagesTable;

use Admin\Model\ServicePageContentModel;
use Admin\Model\ServicePageContentTable;

use Admin\Model\UserContactsTable;
use Admin\Model\UserContactsModel;

use Admin\Model\ColorTable;
use Admin\Model\ColorModel;

use Admin\Model\SliderColorTable;
use Admin\Model\SliderColorModel;

use Admin\Model\PagesTable;
use Admin\Model\PagesModel;

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

    //Service History Table
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Admin\Model\LoginTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new LoginTable($dbAdapter);
                    return $table;
                },

                'Admin\Model\SliderTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new SliderTable($dbAdapter);
                    return $table;
                },

                'Admin\Model\MenuTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new MenuTable($dbAdapter);
                    return $table;
                },

                'Admin\Model\CountryTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CountryTable($dbAdapter);
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
                'Admin\Model\EcommercePackageTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new EcommercePackageTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\UserContactsTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserContactsTable($dbAdapter);
                    return $table;
                },

                'Admin\Model\OfferDatesTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new OfferDatesTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\WebPackageTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new WebPackageTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\WebPackageSpecificationTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new WebPackageSpecificationTable($dbAdapter);
                    return $table;
                },

                'Admin\Model\EmailTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new EmailTable($dbAdapter);
                    return $table;
                },

                'Admin\Model\PhoneTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new PhoneTable($dbAdapter);
                    return $table;
                },

                'Admin\Model\ContactsTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ContactsTable($dbAdapter);
                    return $table;
                },

                'Admin\Model\UserEmailTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserEmailTable($dbAdapter);
                    return $table;
                },

                'Admin\Model\LogoTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new LogoTable($dbAdapter);
                    return $table;
                },

                'AdminAuth' => function($sm)
                {
                    $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');     
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 'login','username','password', 'MD5(?)');  
                    $authService = new AuthenticationService();     
                    $authService->setAdapter($dbTableAuthAdapter);      
                    //$authService->setStorage($sm->get('Album\Model\MyAuthStorage'));
                    return $authService;
                },
                
                'Admin\Model\OtherServicesTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new OtherServicesTable($dbAdapter);
                    return $table;
                },
                        
                'Admin\Model\ServiceTemplateTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ServiceTemplateTable($dbAdapter);
                    return $table;
                },  
                        
                'Admin\Model\ServicePagesTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ServicePagesTable($dbAdapter);
                    return $table;
                },    
                        
                'Admin\Model\ServicePageContentTable' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ServicePageContentTable($dbAdapter);
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

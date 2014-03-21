<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Session\Container;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Admin\Model\WebPackageModel;
use Admin\Model\WebPackageTable;

use Admin\Model\WebPackageSpecificationModel;
use Admin\Model\WebPackageSpecificationTable;

use Admin\Model\MenuTable;
use Admin\Model\MenuModel;

use Admin\Model\LogoTable;
use Admin\Model\LogoModel;

use Application\Model\UserContactsModel;
use Application\Model\UserContactsTable;

use Admin\Model\OtherServicesModel;
use Admin\Model\OtherServicesTable;

use Admin\Model\ColorTable;
use Admin\Model\ColorModel;

use Admin\Model\LanguagesModel;
use Admin\Model\LanguagesTable;

class WebsitePackageController extends AbstractActionController
{  
      protected $webPackageTable;
      protected $webPackageSpecificationTable;
      protected $menuTable;
      protected $logoTable;
      protected $contactsTable;
      protected $otherServicesTable;
      protected $color;
      protected $LanguagesTable;


    public function getWebPackageTable()
    {
        if(!$this->webPackageTable)
        {
            $sm= $this->getServiceLocator();
            $this->webPackageTable = $sm->get('Admin\Model\webPackageTable'); 
        }
        return $this->webPackageTable;
    }
    public function getWebPackageSpecificationTable()
    {
        if(!$this->webPackageSpecificationTable)
        {
            $sm= $this->getServiceLocator();
            $this->webPackageSpecificationTable = $sm->get('Admin\Model\WebPackageSpecificationTable'); 
        }
        return $this->webPackageSpecificationTable;
    }
   public function getMenuTable()
    {
        if(!$this->menuTable)
        {
            $sm= $this->getServiceLocator();
            $this->menuTable = $sm->get('Admin\Model\MenuTable'); 
        }
        return $this->menuTable;
    }
    public function getOtherServicesTable()
    {
        if(!$this->otherServicesTable)
        {
            $sm= $this->getServiceLocator();
            $this->otherServicesTable = $sm->get('Admin\Model\otherServicesTable'); 
        }
        return $this->otherServicesTable;
    }

    public function getLogoTable()
    {
        if(!$this->logoTable)
        {
            $sm= $this->getServiceLocator();
            $this->logoTable = $sm->get('Admin\Model\LogoTable'); 
        }
        return $this->logoTable;
    }

    public function getContactsTable()
    {
        if(!$this->contactsTable)
        {
            $sm= $this->getServiceLocator();
            $this->contactsTable = $sm->get('Admin\Model\ContactsTable'); 
        }
        return $this->contactsTable;
    }
    public function getColorTable()
    {
        if(!$this->colorTable)
        {
            $sm= $this->getServiceLocator();
            $this->colorTable = $sm->get('Admin\Model\ColorTable'); 
        }
        return $this->colorTable;
    }
    public function getLanguagesTable()
    {
        if(!$this->languagesTable)
        {
            $sm= $this->getServiceLocator();
            $this->languagesTable = $sm->get('Admin\Model\LanguagesTable'); 
        }
        return $this->languagesTable;
    }

    public function indexAction()
    {  
        $this->layout("layout/layout");

	$lid = $this->getLanguagesTable()->listLanguagesSessionDatas();
        $languageId = $lid->current();
       
        $this->layout()->setVariables(array(
            'listAllMenuDatas' => $this->getMenuTable()->listMenuDatas($languageId['id']),
            'listLogos' => $this->getLogoTable()->listLogo(),
            'listContactusDatas' => $this->getContactsTable()->listAllContactsData(),
	    'color' => $this->getColorTable()->getColor(),
        ));
        
        
         $this->layout()->setVariables(array(
            'listAllMenuDatas' => $this->getMenuTable()->listMenuDatas($languageId['id']),
        ));
        
    	return new ViewModel(array(  
                'webpackages'   =>$this->getWebPackageTable()->listAllWebPackage(), 
                'otherServices' =>$this->getOtherServicesTable()->listAllOtherServices(),
                'otherServicesTitle'=>$this->getOtherServicesTable()->listOtherServicesTitle(),
                'specifications' =>$this->getWebPackageSpecificationTable()->listAllWebPackageSpecification(),
                'listMenuDatasImageWeb' => $this->getMenuTable()->listMenuDatasImageWeb($languageId['id']	),
       ));
    }
}

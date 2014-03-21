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

use Admin\Model\MenuTable;
use Admin\Model\MenuModel;

use Admin\Model\LogoTable;
use Admin\Model\LogoModel;

use Application\Model\UserContactsModel;
use Application\Model\UserContactsTable;

use Admin\Model\ColorTable;
use Admin\Model\ColorModel;

use Admin\Model\LanguagesModel;
use Admin\Model\LanguagesTable;

class OurProductController extends AbstractActionController
{

    protected $menuTable;
    protected $logoTable;
    protected $contactsTable;
    protected $color;
    protected $LanguagesTable;

	public function getMenuTable()
    {
        if(!$this->menuTable)
        {
            $sm= $this->getServiceLocator();
            $this->menuTable = $sm->get('Admin\Model\MenuTable'); 
        }
        return $this->menuTable;
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

	$lid = $this->getLanguagesTable()->listLanguagesSessionDatas();
        $languageId = $lid->current();
      
        $this->layout()->setVariables(array(
            'listAllMenuDatas' => $this->getMenuTable()->listMenuDatas($languageId['id']),
            'listLogos' => $this->getLogoTable()->listLogo(),
            'listContactusDatas' => $this->getContactsTable()->listAllContactsData(),
	    'color' => $this->getColorTable()->getColor(),
            
        ));

        $viewModel = new ViewModel(array(
           'listMenuDatasImage' => $this->getMenuTable()->listMenuDatasImageProducts($languageId['id']),
        ));
        return $viewModel;
                
    }
    public function colorAction()
    {
         $color= $_POST['vals'];    
         
         $this->layout()->setVariables(array(
            'colors' => $this->getColorTable()->addColor($color),
        ));
        
    }
}

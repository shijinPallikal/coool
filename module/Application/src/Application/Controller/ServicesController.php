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

use Admin\Model\ServicePagesModel;
use Admin\Model\ServicePagesTable;

use Admin\Model\ServiceTemplateModel;
use Admin\Model\ServiceTemplateTable;

use Admin\Model\ServicePageContentModel;
use Admin\Model\ServicePageContentTable;

use Admin\Model\ColorTable;
use Admin\Model\ColorModel;

use Admin\Model\LanguagesModel;
use Admin\Model\LanguagesTable;

class ServicesController extends AbstractActionController
{
      protected $menuTable;
      protected $logoTable;
      protected $contactsTable;
      protected $servicePagesTable;
      protected $serviceTemplateTable;
      protected $servicePageContentTable;
      protected $color;



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
    public function getServicePagesTable()
    {
        if(!$this->servicePagesTable)
        {
            $sm= $this->getServiceLocator();
            $this->servicePagesTable= $sm->get('Admin\Model\servicePagesTable'); 
        }
        return $this->servicePagesTable;
    }
    public function getServiceTemplateTable()
    {
        if(!$this->serviceTemplateTable)
        {
            $sm= $this->getServiceLocator();
            $this->serviceTemplateTable= $sm->get('Admin\Model\serviceTemplateTable'); 
        }
        return $this->serviceTemplateTable;
    }
    public function getServicePageContentTable()
    {
        if(!$this->servicePageContentTable)
        {
            $sm= $this->getServiceLocator();
            $this->servicePageContentTable= $sm->get('Admin\Model\servicePageContentTable'); 
        }
        return $this->servicePageContentTable;
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
	$config = $this->getServiceLocator()->get('config');            
        $this->layout("layout/layout");

        $serviceId=(int) $this->params()->fromRoute('serId');   
        $id=(int) $this->params()->fromRoute('id');
	
	$lid = $this->getLanguagesTable()->listLanguagesSessionDatas();
        $languageId = $lid->current();
                     
        $this->layout()->setVariables(array(
            'listAllMenuDatas' => $this->getMenuTable()->listMenuDatas($languageId['id']),
            'listLogos' => $this->getLogoTable()->listLogo(),
            'listContactusDatas' => $this->getContactsTable()->listAllContactsData($serviceId),
	    'color' => $this->getColorTable()->getColor(),
        ));      
       
       
        if($id){
             $pageId=$id;
             $servicePages=$this->getServicePagesTable()->ServicePagesDataSingle($id);
             foreach($servicePages as $page){
                $pageName= $page['page_name'];
             }            
        }
        else{
             $servicePages=$this->getServicePagesTable()->listAllServicePages($serviceId);
             $first =true;
             foreach($servicePages as $page){
                if($first){
                    $pageId=$page['id'];
                    $pageName=$page['page_name'];
                    $first=false;
                }
             }        
        }     
        
    	return new ViewModel(array(  
            'servicePage'   => $this->getServicePagesTable()->listAllServicePages($serviceId),  
            'pageName'      => $pageName,
            'serviceId'     => $serviceId,
            'serPageContent'=>$this->getServicePageContentTable()->pageContentData($pageId),
            'listMenuDataImageServices' => $this->getMenuTable()->listMenuDatasImageservices($languageId['id']),
                
        ));
    }

	public function colorAction()
    {
         $color= $_POST['vals'];    
         
         $this->layout()->setVariables(array(
            'colors' => $this->getColorTable()->addColor($color),
        ));
        
    }
    
//    public function ajaxlistAction(){
//        $request=$this->getRequest();
//        $pageId=$request->getPost('pageId');
//        $pageContent=$this->getServicePageContentTable()->pageContentData($pageId);
//        foreach($pageContent as $content)
//        {
//            echo $content['content_description'];
//        }
//        exit;
//    }
    
//    public function ajaxPageHeadingAction(){
//        $request=$this->getRequest();
//        $pageId=$request->getPost('pageId');
//        $pageDetail=$this->getServicePagesTable()->ServicePagesDataSingle($pageId);
//        foreach($pageDetail as $page)
//        {
//            echo $page['page_name'];
//        }
//        exit;
//    }
    
}




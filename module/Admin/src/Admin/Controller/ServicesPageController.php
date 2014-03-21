<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Validator\File\Size;
use Zend\Session\Storage\SessionStorage;
use Zend\Session\SessionManager; 

use Admin\Model\ServicePagesModel;
use Admin\Model\ServicePagesTable;

use Admin\Model\ServiceTemplateModel;
use Admin\Model\ServiceTemplateTable;

class ServicesPageController extends AbstractActionController
{
    protected $servicePagesTable;
    protected $serviceTemplateTable;
    

    public function getServicePagesTable()
    {
        if(!$this->servicePagesTable)
        {
            $sm= $this->getServiceLocator();
            $this->servicePagesTable = $sm->get('Admin\Model\servicePagesTable'); 
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
    
    //Actions
    public function indexAction()
    {    
        $serviceId=(int) $this->params()->fromRoute('serId');       
        $this->layout('layout/adminDashboardLayout');
        return new ViewModel(array(
                    'serviceId'=>$serviceId,                               
                ));
    }
    
    public function ajaxListAction(){

        $serviceId=$this->getRequest()->getPost('serId');  
        $viewModel = new ViewModel(array(
            'listServicesPage' => $this->getServicePagesTable()->ServicePageWithTemplate($serviceId),
            'serviceId'        => $serviceId,
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));

        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function addAction()
    {              
        $serviceId=(int) $this->params()->fromRoute('serId');
        $this->layout('layout/adminDashboardLayout');
        $request=$this->getRequest(); 
        $this->flashMessenger()->addMessage('');
        if($request->isPost())
        {   //exit('ok'); 
            $dataServicesPage = new ServicePagesModel();
            $dataServicesPage->setPageName($request->getPost('service_pagename'));  
            $dataServicesPage->setPageTemplate($request->getPost('service_template'));
            $dataServicesPage->setServiceMenuNo($serviceId);
            $lastId = $this->getServicePagesTable()->saveServicePageData($dataServicesPage);  
            $this->flashMessenger()->addMessage('Data Inserted Successfully');
            return $this->redirect()->toRoute('admin/servicespage',array('serId'=>$serviceId));  
        }

        return new ViewModel(array(
            'serviceId'      => $serviceId,
            'flashMessages'   => $this->flashMessenger()->getMessages(),
            'serviceTemplate' => $this->getServiceTemplateTable()->listAllServiceTemplates(),
        ));        
    }
    
    
    public function editAction()
    {
        $id=(int) $this->params()->fromRoute('id');
        $serviceId=(int) $this->params()->fromRoute('serId');
        $this->layout('layout/adminDashboardLayout');
        $request=$this->getRequest();     
	$upload = $this->UploadFilesLib();    
          $this->flashMessenger()->addMessage('');
          $servicePage=$this->getServicePagesTable()->ServicePagesDataSingle($id);
                  
        if($request->isPost())
        {           
            //exit('ok'); 
            $pageServicesData = new ServicePagesModel();
            $pageServicesData->setId($id);            
            $pageServicesData->setPageName($request->getPost("service_pagename")); 
            $pageServicesData->setPageTemplate($request->getPost("service_template"));
            $pageServicesData->setServiceMenuNo($serviceId);
            $lastId = $this->getServicePagesTable()->updateServicePageData($pageServicesData);  
            $this->flashMessenger()->addMessage('Data Inserted Successfully');
            return $this->redirect()->toRoute('admin/servicespage',array('serId'=>$serviceId));  
        }

        return new ViewModel(array(
            'servicePage'  =>$servicePage,
            'serviceId'   =>$serviceId,
            'serviceTemplate' => $this->getServiceTemplateTable()->listAllServiceTemplates(),
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));
        
    }
    
    public function editTitleAction()
    {
        //$id=(int) $this->params()->fromRoute('id');
        $this->layout('layout/adminDashboardLayout');
        $request=$this->getRequest();     
	          $this->flashMessenger()->addMessage('');
        $otherServiceTitle=$this->getOtherServicesTable()->listOtherServicesTitle();
          
           
        if($request->isPost())
        {   
            //exit('ok'); 
             foreach($otherServiceTitle as $title){ 
                  $id = $title['id'];}             
            $otherServicesTitle = new OtherServicesModel();
            $otherServicesTitle->setId($id);                      
            $otherServicesTitle->setServiceTitle($request->getPost("service_title"));  
            $otherServicesTitle->setServiceDescription($request->getPost("service_description")); 
            $lastId = $this->getOtherServicesTable()->updateOtherServices($otherServicesTitle);  
            $this->flashMessenger()->addMessage('Title Updated Successfully');
            return $this->redirect()->toRoute('admin/otherservices/edittitle');  
        }

        return new ViewModel(array(
            'otherService'  => $otherServiceTitle,
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));
        
    }
    
    public function deleteAction(){
        
         $delId = $this->getRequest()->getPost('delId');
             $this->getServicePagesTable()->deleteServicePageData($delId);           
         exit;
         
    }
    
}

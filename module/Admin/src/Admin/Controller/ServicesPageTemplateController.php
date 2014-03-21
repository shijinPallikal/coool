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

class ServicesPageTemplateController extends AbstractActionController
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
        $this->layout('layout/adminDashboardLayout');
        return new ViewModel(array(
                               
                ));
    }
    
    public function ajaxListAction(){

        $viewModel = new ViewModel(array(
            'listPageTemplates' => $this->getServiceTemplateTable()->listAllServiceTemplates(),
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));

        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function addAction()
    {
        $this->layout('layout/adminDashboardLayout');
        $request=$this->getRequest(); 
        $this->flashMessenger()->addMessage('');
        if($request->isPost())
        {      
            $template=$request->getPost('page_template');
            //exit('ok'); 
            $dataPageTemplate = new ServiceTemplateModel();
            $dataPageTemplate->setTemplateName($request->getPost('template_name'));  
            $dataPageTemplate->setServiceTemplate(stripslashes($template)); 
            $lastId = $this->getServiceTemplateTable()->saveServicePageTemplateData($dataPageTemplate);  
            $this->flashMessenger()->addMessage('Data Inserted Successfully');
            return $this->redirect()->toRoute('admin/servicespagetemplate');  
        }

        return new ViewModel(array(
            'flashMessages'   => $this->flashMessenger()->getMessages(),
            //'serviceTemplate' => $this->getServiceTemplateTable()->listAllServiceTemplates(),
        ));        
    }
    
    
    public function editAction()
    {
        $id=(int) $this->params()->fromRoute('id');
        $this->layout('layout/adminDashboardLayout');
        $request=$this->getRequest(); 
        $this->flashMessenger()->addMessage('');
        if($request->isPost())
        {           
            $template=$request->getPost('page_template');      
            $dataPageTemplate = new ServiceTemplateModel();
            $dataPageTemplate->setId($id);
            $dataPageTemplate->setTemplateName($request->getPost('template_name'));  
            $dataPageTemplate->setServiceTemplate(stripslashes($template)); 
            $lastId = $this->getServiceTemplateTable()->updateServicePageTemplateData($dataPageTemplate);        
            $this->flashMessenger()->addMessage('Data Inserted Successfully');
            return $this->redirect()->toRoute('admin/servicespagetemplate');  
        }

        return new ViewModel(array(            
            'servicePageTemplate' => $this->getServiceTemplateTable()->serviceTemplateDataSingle($id),
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
        {   //exit('ok'); 
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
             $this->getServiceTemplateTable()->deleteServicePageTemplateData($delId);           
         exit;
         
    }
    
}

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

use Admin\Model\OtherServicesModel;
use Admin\Model\OtherServicesTable;

class OtherServicesController extends AbstractActionController
{
    protected $otherServicesTable;
    
    public function getOtherServicesTable()
    {
        if(!$this->otherServicesTable)
        {
            $sm= $this->getServiceLocator();
            $this->otherServicesTable = $sm->get('Admin\Model\otherServicesTable'); 
        }
        return $this->otherServicesTable;
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
            'listAllMenuData' => $this->getOtherServicesTable()->listAllOtherServices(),
            'flashMessages' => $this->flashMessenger()->getMessages()

        ));

        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function addAction()
    {
        $config=$this->getServiceLocator()->get('config');
        $this->layout('layout/adminDashboardLayout');
        $request=$this->getRequest();     
	$upload = $this->UploadFilesLib();    
          $this->flashMessenger()->addMessage('');
        if($request->isPost())
        {           
            //exit('ok'); 
            $otherServicesData = new OtherServicesModel();
            $path=$config['defaultValues']['upload_path'];
            if(isset($_FILES['field']['name'][0]) && !empty($_FILES['field']['name'][0])){
                        $file= $_FILES['field']['name'];                                                    
                        $serviceImg = $upload->getRandFileNa($file);                             
                        $upload->copyFile('field',$path.'/images/products/other_service', 1, $serviceImg);
            }      
            //Current User Id from Session
	    $title=stripslashes($request->getPost("service_title"));
            $desc=stripslashes($request->getPost("service_description"));
            $otherServicesData->setServiceTitle($title);  
            $otherServicesData->setServiceLink($request->getPost("service_link"));  
            $otherServicesData->setServiceDescription($desc); 
            $otherServicesData->setServicePrice($request->getPost("service_price"));
            $otherServicesData->setServiceImage($serviceImg); 
            $lastId = $this->getOtherServicesTable()->saveOtherServices($otherServicesData);  
            $this->flashMessenger()->addMessage('Data Inserted Successfully');
            return $this->redirect()->toRoute('admin/otherservices/add');  
        }

        return new ViewModel(array(
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));
        
    }
    
    
    public function editAction()
    {
        $id=(int) $this->params()->fromRoute('id');
        $this->layout('layout/adminDashboardLayout');
        $request=$this->getRequest();   
        $config=$this->getServiceLocator()->get('config');
	$upload = $this->UploadFilesLib();    
          $this->flashMessenger()->addMessage('');
          $service=$this->getOtherServicesTable()->singleOtherServicesrow($id);
                  
        if($request->isPost())
        {           
            //exit('ok'); 
            $otherServicesData = new OtherServicesModel();
            $otherServicesData->setId($id);
            $path=$config['defaultValues']['upload_path'];
            if(isset($_FILES['field']['name'][0]) && !empty($_FILES['field']['name'][0])){
                
                foreach($service as $ser){
                    unlink($path.'/images/products/other_service/'.$ser['service_image']);
                }
                $file= $_FILES['field']['name'];                                                    
                $serviceImg = $upload->getRandFileNa($file);                             
                $upload->copyFile('field',$path.'/images/products/other_service', 1, $serviceImg);
                $otherServicesData->setServiceImage($serviceImg); 
            }      
            //Current User Id from Session
          	$title=stripslashes($request->getPost("service_title"));
                $desc=stripslashes($request->getPost("service_description"));
            $otherServicesData->setServiceTitle($title); 
            $otherServicesData->setServiceLink($request->getPost("service_link")); 
            $otherServicesData->setServiceDescription($desc); 
            $otherServicesData->setServicePrice($request->getPost("service_price"));
            
            $lastId = $this->getOtherServicesTable()->updateOtherServices($otherServicesData);  
            $this->flashMessenger()->addMessage('Data Inserted Successfully');
            return $this->redirect()->toRoute('admin/otherservices');  
        }

        return new ViewModel(array(
            'otherService'  =>$service,
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
        //$delId = (int) $this->params()->fromRoute('id');
        $config=$this->getServiceLocator()->get('config');
        $delId = $this->getRequest()->getPost('delId');
        $res=$this->getOtherServicesTable()->singleOtherServicesrow($delId);
        $path=$config['defaultValues']['upload_path'];
        foreach($res as $rs){
            unlink($path.'/images/products/other_service/'.$rs['service_image']);
        }           
          
          $this->getOtherServicesTable()->deleteOtherServices($delId);
        exit;
         
    }
    
}

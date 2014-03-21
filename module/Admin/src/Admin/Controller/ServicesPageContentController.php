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

use Admin\Model\ServicePageContentModel;
use Admin\Model\ServicePageContentTable;

class ServicesPageContentController extends AbstractActionController
{
    protected $servicePagesTable;
    protected $serviceTemplateTable;
    protected $servicePageContentTable;

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
    
    public function getServicePageContentTable()
    {
        if(!$this->servicePageContentTable)
        {
            $sm= $this->getServiceLocator();
            $this->servicePageContentTable= $sm->get('Admin\Model\servicePageContentTable'); 
        }
        return $this->servicePageContentTable;
    }
    
    //Actions
    public function indexAction()
    {     
        $id=(int) $this->params()->fromRoute('id');
        $serviceId=(int) $this->params()->fromRoute('serId');
        $this->layout('layout/adminDashboardLayout');
        return new ViewModel(array(
                       'servicePageId'=>$id,   
                       'serviceId'    =>$serviceId,
                ));
    }
    
    public function ajaxListAction(){
        $id=$this->getRequest()->getPost('pageId');
        $serviceId=$this->getRequest()->getPost('serId');
        $viewModel = new ViewModel(array(
            'listPageContent' => $this->getServicePageContentTable()->pageContentData($id),
            'pageId'          => $id,
            'serviceId'       => $serviceId,
            'flashMessages'   => $this->flashMessenger()->getMessages(),
        ));

        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
//    public function addAction()
//    {
//        $this->layout('layout/adminDashboardLayout');
//        $id=(int) $this->params()->fromRoute('id');
//        $request=$this->getRequest(); 
//        $upload = $this->UploadFilesLib();   
//        $this->flashMessenger()->addMessage('');
//        if($request->isPost())
//        { 
//            //exit('ok'); 
//            $path='/var/www/coolwebsite/public';
//            if(isset($_FILES['content_img']['name'][0]) && !empty($_FILES['content_img']['name'][0])){
//                        $file= $_FILES['content_img']['name'];                                                    
//                        $contentImg = $upload->getRandFileNa($file);                             
//                        $upload->copyFile('content_img',$path.'/images/products/service_page_content', 1, $contentImg);
//            }   
//            $dataPageContent = new ServicePageContentModel();
//            $dataPageContent->setPageId($id);
//            $dataPageContent->setContentTitle($request->getPost('content_title'));            
//            $dataPageContent->setContentDescription($request->getPost('content_description'));     
//            $dataPageContent->setContentImage($contentImg);
//            $lastId = $this->getServicePageContentTable()->saveServicePageContentData($dataPageContent);  
//            $this->flashMessenger()->addMessage('Data Inserted Successfully');
//            return $this->redirect()->toRoute('admin/servicespagecontent',array('id'=>$id));  
//        }
//
//        return new ViewModel(array(
//            'flashMessages'   => $this->flashMessenger()->getMessages(),
//            'serviceTemplate' => $this->getServiceTemplateTable()->listAllServiceTemplates(),
//        ));        
//    }    
    
    public function addAction()
    {
            
        $this->layout('layout/adminDashboardLayout');
        $id=(int) $this->params()->fromRoute('id');
        $serviceId=(int) $this->params()->fromRoute('serId');
        $request=$this->getRequest(); 
        $pageTemplate=$this->getServicePagesTable()->ServicePagesDataSingle($id);
        foreach($pageTemplate as $temp){
           $serviceTemplate=$this->getServiceTemplateTable()->serviceTemplateDataSingle($temp['page_template']);           
        }  
        $this->flashMessenger()->addMessage('');
        if($request->isPost())
        {     
            $pageContent=$request->getPost('page_content');
            $dataPageContent = new ServicePageContentModel();
            $dataPageContent->setPageId($id);            
            $dataPageContent->setContentDescription(stripslashes($pageContent));
            $lastId = $this->getServicePageContentTable()->saveServicePageContentData($dataPageContent);  
            $this->flashMessenger()->addMessage('Data Inserted Successfully');
            return $this->redirect()->toRoute('admin/servicespagecontent',array('serId'=>$serviceId,'id'=>$id));  
        }
        return new ViewModel(array(
            'flashMessages'   => $this->flashMessenger()->getMessages(),
            'serviceTemplate' => $serviceTemplate,
            'pageId'          => $id,
            'serviceId'       => $serviceId
        ));        
    } 
    
//    public function editAction()
//    {
//        $id=(int) $this->params()->fromRoute('id');
//        $id2=(int) $this->params()->fromRoute('id2');       
//        $this->layout('layout/adminDashboardLayout');
//        $request=$this->getRequest();     
//	$upload = $this->UploadFilesLib();    
//        $this->flashMessenger()->addMessage('');
//        $pageContent=$this->getServicePageContentTable()->pageContentDataSingle($id2);                  
//        if($request->isPost())
//        {   
//            $dataPageContent = new ServicePageContentModel();
//            $dataPageContent->setId($id2);
//            $path='/var/www/coolwebsite/public';
//            if(isset($_FILES['content_img']['name'][0]) && !empty($_FILES['content_img']['name'][0])){     
//                if(count($pageContent!=0)){
//                foreach($pageContent as $content){
//                    unlink($path.'/images/products/service_page_content/'.$content['content_image']);
//                }}
//                        $file= $_FILES['content_img']['name'];                                                    
//                        $contentImg = $upload->getRandFileNa($file);                             
//                        $upload->copyFile('content_img',$path.'/images/products/service_page_content', 1, $contentImg);
//                        $dataPageContent->setContentImage($contentImg); 
//            }            
//            $dataPageContent->setContentTitle($request->getPost('content_title'));            
//            $dataPageContent->setContentDescription($request->getPost('content_description')); 
//            $lastId = $this->getServicePageContentTable()->updateServicePageContentData($dataPageContent);  
//            $this->flashMessenger()->addMessage('Data Inserted Successfully');
//            return $this->redirect()->toRoute('admin/servicespagecontent',array('id'=>$id));  
//        }
//
//        return new ViewModel(array(
//            'pageContent'  =>$pageContent,
//            'serviceTemplate' => $this->getServiceTemplateTable()->listAllServiceTemplates(),
//            'flashMessages' => $this->flashMessenger()->getMessages(),
//        ));
//        
//    }
    
    
    
    public function editAction()
    {
        $id=(int) $this->params()->fromRoute('id');
        $id2=(int) $this->params()->fromRoute('id2');  
        $serviceId=(int) $this->params()->fromRoute('serId');
        $this->layout('layout/adminDashboardLayout');
        $request=$this->getRequest();       
        $this->flashMessenger()->addMessage('');
        $pageContent=$this->getServicePageContentTable()->pageContentDataSingle($id2);                  
        if($request->isPost())
        {   
            $pageContent=$request->getPost('page_content');
            $dataPageContent = new ServicePageContentModel();
            $dataPageContent->setId($id2);
            $dataPageContent->setContentDescription(stripslashes($pageContent)); 
            $lastId = $this->getServicePageContentTable()->updateServicePageContentData($dataPageContent);  
            $this->flashMessenger()->addMessage('Data Inserted Successfully');
            return $this->redirect()->toRoute('admin/servicespagecontent',array('id'=>$id));  
        }

        return new ViewModel(array(
            'pageContent'  =>$pageContent,
            'pageId'       =>$id,
            'serviceId'    =>$serviceId,
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
            $this->getServicePageContentTable()->deleteServicePageContentData($delId);
        exit;
         
    }
    
}

<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace AgentSuperAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Validator\File\Size;
use Zend\Session\Storage\SessionStorage;
use Zend\Session\SessionManager;

 
use Admin\Model\BigPackageModel;
use Admin\Model\BigPackageTable;


class BigPackageController extends AbstractActionController
{

    protected $bigPackageTable;
    protected $authService;
    
    public function getBigPackageTable()
    {
        if(!$this->bigPackageTable)
        {
            $sm= $this->getServiceLocator();
            $this->bigPackageTable = $sm->get('Admin\Model\BigPackageTable'); 
        }
        return $this->bigPackageTable;
    }

    public function getAuthService()
    {
        if (! $this->authService)
        {
            $this->authService = $this->getServiceLocator()->get('AgentSuperAdminAuth');
        }        
        return $this->authService;
    }

    

    //Actions
    public function indexAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
        
            $this->layout('layout/agentSuperAdminDashboardLayout');
        }
        else
        {
            return $this->redirect()->toRoute('agentSuperAdmin');         
        }
        
    }
    
    public function addAction()
    {
        $config = $this->getServiceLocator()->get('config');
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/agentSuperAdminDashboardLayout');
            $request=$this->getRequest();
            if($request->isPost())
            {

                $bigPackageData = new BigPackageModel();
                
                //Current User Id from Session
                $session = new Container('agentSuperAdmin'); 
                $userId = $session->offsetGet('agentSuperAdminId');  

                $bigPackageData->setProductTitle($request->getPost('product_title'));
                $bigPackageData->setDescription($request->getPost("product_description"));
                $bigPackageData->setUrl($request->getPost("curl"));
                $bigPackageData->setUserId($userId);
                $bigPackageData->setUser("agentSuperAdmin");
                $bigPackageData->setCreatedOn(date('Y-m-d H:i:s'));
                $lastId=$this->getBigPackageTable()->saveBigPackageData($bigPackageData);

                

                
                // $path           ='';
                //$path='/var/www/coool/public';
                $path= $config['defaultValues']['upload_path'];
                if($this->params()->fromFiles('field1') != '')
                {

                    $file1  = $this->params()->fromFiles('field1');
                    $isFileUploaded = 1;
                    
                    $ext1= explode('.',$file1['name']);
                    $img1= $lastId.'_big.'.$ext1[1];
                    
                    if(!empty($file1['name']))
                    {         
                        $size = new Size(array('min'=>10, 'max' => 9000000)); //minimum bytes filesize
                        $adapter = new \Zend\File\Transfer\Adapter\Http();
                        $adapter->setValidators(array($size), $file1['name']);
                        if (!$adapter->isValid('field1'))
                        {
                            $dataError = $adapter->getMessages();
                            $error = array();
                            foreach($dataError as $key=>$row)
                            {
                                $error[] = $row;
                            }                             
                            $this->flashmessenger()->addMessage($error[0]);
                            $isFileUploaded = 0;
                        }
                        else
                        {    
                            $paths1= $path.'/images/products/agent_super_admin/big_package/'.$img1;
                        
                            move_uploaded_file($_FILES['field1']['tmp_name'],$paths1);
                            $this->getBigPackageTable()->updateBigPackageImage1($lastId,$img1);
                        }
                    }

                }

                

                if($this->params()->fromFiles('field2') != '')
                {
                    $file2  = $this->params()->fromFiles('field2');
                    $isFileUploaded = 1;
                    
                    $ext2= explode('.',$file2['name']);
                    $img2= $lastId.'_small.'.$ext2[1];
                    if(!empty($file2['name']))
                    {         
                        $size2 = new Size(array('min'=>10, 'max' => 9000000)); //minimum bytes filesize
                        $adapter2 = new \Zend\File\Transfer\Adapter\Http();
                        $adapter2->setValidators(array($size2), $file2['name']);
                        if (!$adapter2->isValid('field2'))
                        {
                            //echo"error";
                            $dataError = $adapter2->getMessages();
                            $error = array();
                            foreach($dataError as $key=>$row)
                            {
                                $error[] = $row;
                            }                             
                            $this->flashmessenger()->addMessage($error[0]);
                            $isFileUploaded = 0;
                        }
                        else
                        {
                            $paths2= $path.'/images/products/agent_super_admin/big_package/'.$img2;
                        
                            move_uploaded_file($_FILES['field2']['tmp_name'],$paths2);
                            $this->getBigPackageTable()->updateBigPackageImage2($lastId,$img2);
                            
                        }
                    }
                    
                }
                

                return new ViewModel(array(
                    'flashMessages' => $this->flashMessenger()->getMessages(),
                ));
            }
        }
        else
        {
            return $this->redirect()->toRoute('agentSuperAdmin');         
        }

    }

    public function ajaxListAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $viewModel= new ViewModel(array(
                'listAllSuperAdminBigPackage' => $this->getBigPackageTable()->listAllSuperAdminBigPackage(),
            ));

            $viewModel->setTerminal(true);
            return $viewModel;
        }
        else
        {
            return $this->redirect()->toRoute('agentSuperAdmin');         
        }
        
    }


    //Stataus to Off
   /* public function statusAction()
    {
        //Status off
        if($_POST['offId'] != '')
        {
            if($this->getBigPackageTable()->updateBigPackageStatusOff($_POST['offId']))
            {     
                echo "Status Edited SuccessFully....";exit;
            }
            else
            {
                echo "You can't Change Status....";exit;
            }
        }
        //Status On
        if($_POST['onId'] != '')
        {

            if($this->getBigPackageTable()->updateBigPackageStatusOn($_POST['onId']))
            {     
                echo "Status Edited SuccessFully....";exit;
            }
            else
            {
                echo "You can't Change Status....";exit;
            }
        }
        
    }

    public function deleteAction()
    {
        $delId= $_POST['delid'];
       
        if($delId !='')
        {
            if($this->getBigPackageTable()->deleteBigPackageData($delId))
            {        
                echo "Data deleted SuccessFully....";exit;
            }
            else
            {
                echo "You can't Delete....";exit;
            }
        }
        else
        {
            echo "Contct Your Admin";exit;
        }

    }

    public function editAction()
    {
        $this->layout('layout/adminDashboardLayout');
        $id= (int) $this->params()->fromRoute(id);
        $request = $this->getRequest();
                
        if($request->isPost())
        {
            if($request->getPost("default") == '')
            {
                $default= 0;
            }
            else
            {
                $default= $request->getPost("default");
            }
            //exit;
            $bigPackageData = new BigPackageModel();
            //Current User Id from Session
            $session = new Container('user'); 
            $userId = $session->offsetGet('userId');
            
            $bigPackageData->setId($id);
            $bigPackageData->setProductTitle($request->getPost('product_title'));
            $bigPackageData->setDefault($default);
            $bigPackageData->setDescription($request->getPost("product_description"));
            $bigPackageData->setUrl($request->getPost("curl"));
            $bigPackageData->setUserId($userId);
            $bigPackageData->setArea($request->getPost("area"));
            $bigPackageData->setOfferDate($request->getPost("pre-select-dates"));
            $bigPackageData->setUpdatedOn(date('Y-m-d H:i:s'));
            
            
            // $path           ='';
            $path='/var/www/coool/public';
            if($this->params()->fromFiles('field1') != '')
            {

                $file1  = $this->params()->fromFiles('field1');
                //print_r($file1);
                $isFileUploaded = 1;
                
                $ext1= explode('.',$file1['name']);
                $img1= $id.'_big.'.$ext1[1];
                
                if(!empty($file1['name']))
                {         
                    $size = new Size(array('min'=>10, 'max' => 9000000)); //minimum bytes filesize
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $adapter->setValidators(array($size), $file1['name']);
                    if (!$adapter->isValid('field1'))
                    {
                        $dataError = $adapter->getMessages();
                        $error = array();
                        foreach($dataError as $key=>$row)
                        {
                            $error[] = $row;
                        }                             
                        $this->flashmessenger()->addMessage($error[0]);
                        $isFileUploaded = 0;
                    }
                    else
                    {    
                        $paths1= $path.'/images/products/big_package/'.$img1;
                    
                        move_uploaded_file($_FILES['field1']['tmp_name'],$paths1);
                        //$this->getBigPackageTable()->($id,$img1);
                        $bigPackageData->setImage1($img1);
                    }
                }

            }

            

            if($this->params()->fromFiles('field2') != '')
            {
                $file2  = $this->params()->fromFiles('field2');
                $isFileUploaded = 1;
                //print_r($file2);exit;
                $ext2= explode('.',$file2['name']);
                $img2= $id.'_small.'.$ext2[1];
                if(!empty($file2['name']))
                {         
                    $size2 = new Size(array('min'=>10, 'max' => 9000000)); //minimum bytes filesize
                    $adapter2 = new \Zend\File\Transfer\Adapter\Http();
                    $adapter2->setValidators(array($size2), $file2['name']);
                    if (!$adapter2->isValid('field2'))
                    {
                        //echo"error";
                        $dataError = $adapter2->getMessages();
                        $error = array();
                        foreach($dataError as $key=>$row)
                        {
                            $error[] = $row;
                        }                             
                        $this->flashmessenger()->addMessage($error[0]);
                        $isFileUploaded = 0;
                    }
                    else
                    {
                        $paths2= $path.'/images/products/big_package/'.$img2;
                    
                        move_uploaded_file($_FILES['field2']['tmp_name'],$paths2);
                        //$this->getBigPackageTable()->updateBigPackageImage2($id,$img2);
                        $bigPackageData->setImage2($img2);
                        
                    }
                }
                
            }
            //return new ViewModel(array(
             //   'flashMessages' => $this->flashMessenger()->getMessages(),
            //));
            $this->getBigPackageTable()->updateBigPackageData($bigPackageData);
            return $this->redirect()->toRoute('admin/bigPackage');
        }
        return new ViewModel(array(
            'editBigPackageData'=>$this->getBigPackageTable()->listBigPackageData($id),
        ));       
    }*/
    
}

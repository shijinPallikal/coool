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

 
use Admin\Model\SmallPackageModel;
use Admin\Model\SmallPackageTable;

use Admin\Model\OfferDatesTable;
use Admin\Model\OfferDatesModel;


class SmallPackageController extends AbstractActionController
{


    protected $smallPackageTable;
    protected $offerDatesTable;
    protected $authService;

    public function getSmallPackageTable()
    {
        if(!$this->smallPackageTable)
        {
            $sm= $this->getServiceLocator();
            $this->smallPackageTable = $sm->get('Admin\Model\SmallPackageTable'); 
        }
        return $this->smallPackageTable;
    }

    public function getOfferDatesTable()
    {
        if(!$this->offerDatesTable)
        {
            $sm= $this->getServiceLocator();
            $this->offerDatesTable = $sm->get('Admin\Model\OfferDatesTable'); 
        }
        return $this->offerDatesTable;
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

            $viewModel = new ViewModel(array(
                'flashMessages' => $this->flashMessenger()->getMessages()
            ));
            return $viewModel;
        }
        else
        {
            return $this->redirect()->toRoute('agentSuperAdmin');         
        }
        
        

    }
    
    public function addAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {     
            $this->layout('layout/agentSuperAdminDashboardLayout');
            $request=$this->getRequest();
            if($request->isPost())
            {
                $file  = $this->params()->fromFiles('field2');
                if($file['size'] > 5.243e+6)
                {

                    $this->flashmessenger()->addMessage("You can't Add Because upload Image size is greater than 5MB");
                    return $this->redirect()->toRoute('agentSuperAdmin/smallPackage');
                }
                else
                {
                    $smallPackageData = new SmallPackageModel();
                    
                    //Current User Id from Session
                    $session = new Container('agentSuperAdmin'); 
                    $userId = $session->offsetGet('agentSuperAdminId'); 
                    //echo  $userId; exit;
                    if($request->getPost("default") == '')
                    {
                        $default= 0;
                    }
                    else
                    {
                        $default= $request->getPost("default");
                    }   
                                
                    $smallPackageData->setProductTitle($request->getPost('product_title'));
                    $smallPackageData->setDefault($default);
                    $smallPackageData->setDescription($request->getPost("product_description"));
                    $smallPackageData->setUrl($request->getPost("curl"));
                    $smallPackageData->setUserId($userId);
                    $smallPackageData->setUser('agentSuperAdmin');
                    $smallPackageData->setArea($request->getPost("area"));
                    $smallPackageData->setCreatedOn(date('Y-m-d H:i:s'));
                    $lastId=$this->getSmallPackageTable()->saveSmallPackageData($smallPackageData);

                               
                    // $path           ='';
                    $path='/var/www/coool/public';
                    /*if($this->params()->fromFiles('field1') != '')
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
                                $paths1= $path.'/images/products/agent_super_admin/small_package/'.$img1;
                            
                                move_uploaded_file($_FILES['field1']['tmp_name'],$paths1);
                                $this->getSmallPackageTable()->updateSmallPackageImage1($lastId,$img1);
                            }
                        }

                    }*/

                    

                    if($this->params()->fromFiles('field2') != '')
                    {
                        $file2  = $this->params()->fromFiles('field2');
                        $isFileUploaded = 1;
                        
                        $ext2= explode('.',$file2['name']);
                        $img2= $lastId.'_small.'.$ext2[1];
                        if(!empty($file2['name']))
                        {         
                                $paths2= $path.'/images/products/agent_super_admin/small_package/'.$img2;
                            
                                move_uploaded_file($_FILES['field2']['tmp_name'],$paths2);
                                $this->getSmallPackageTable()->updateSmallPackageImage2($lastId,$img2);
                                
                           
                        }
                        
                    }
                }
                

                return new ViewModel(array(
                    'flashMessages' => $this->flashMessenger()->getMessages(),
                ));

                return $this->redirect()->toRoute('admin/smallPackage');
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
                'listAllSuperAdminPackage' => $this->getSmallPackageTable()->listAllSuperAdminPackage(),
                'listAllSuperAdminPackage2' => $this->getSmallPackageTable()->listAllSuperAdminPackage2(),
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
    public function statusAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $productData = new SmallPackageModel();
            //Status off
            if($_POST['offId'] != '')
            {
                if($this->getSmallPackageTable()->updateSmallPackageAgentAdminStatusOff($_POST['offId']))
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
                if($this->getSmallPackageTable()->updateSmallPackageAgentAdminStatusOn($_POST['onId']))
                {     
                    echo "Status Edited SuccessFully....";exit;
                }
                else
                {
                    echo "You can't Change Status....";exit;
                }
            }
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        } 
        
    }

    public function editAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $id= (int) $this->params()->fromRoute(id);
            $this->layout('layout/agentSuperAdminDashboardLayout');
            $request=$this->getRequest();
            if($request->isPost())
            {
                $file  = $this->params()->fromFiles('field2');
                if($file['size'] > 5.243e+6)
                {

                    $this->flashmessenger()->addMessage("You can't Edit Because upload Image size is greater than 5MB");
                    return $this->redirect()->toRoute('agentSuperAdmin/smallPackage');
                }
                else
                {
                    $smallPackageData = new SmallPackageModel();
                    
                    //Current User Id from Session
                    $session = new Container('agentSuperAdmin'); 
                    $userId = $session->offsetGet('agentSuperAdminId'); 
                    
                    if($request->getPost("default") == '')
                    {
                        $default= 0;
                    }
                    else
                    {
                        $default= $request->getPost("default");
                    }   
                    $smallPackageData->setId($id);            
                    $smallPackageData->setProductTitle($request->getPost('product_title'));
                    $smallPackageData->setDefault($default);
                    $smallPackageData->setDescription($request->getPost("product_description"));
                    $smallPackageData->setUrl($request->getPost("curl"));
                    $smallPackageData->setUserId($userId);
                    $smallPackageData->setUser('agentSuperAdmin');
                    $smallPackageData->setArea($request->getPost("area"));
                    $smallPackageData->setUpdatedOn(date('Y-m-d H:i:s'));
                    $this->getSmallPackageTable()->updateSmallPackageData($smallPackageData);

                               
                    // $path           ='';
                    $path='/var/www/coool/public';
                    /*if($this->params()->fromFiles('field1') != '')
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
                                $paths1= $path.'/images/products/agent_super_admin/small_package/'.$img1;
                            
                                move_uploaded_file($_FILES['field1']['tmp_name'],$paths1);
                                $this->getSmallPackageTable()->updateSmallPackageImage1($lastId,$img1);
                            }
                        }

                    }*/

                    

                    if($this->params()->fromFiles('field2') != '')
                    {
                        $file2  = $this->params()->fromFiles('field2');
                        $isFileUploaded = 1;
                        
                        $ext2= explode('.',$file2['name']);
                        $img2= $id.'_small.'.$ext2[1];
                        if(!empty($file2['name']))
                        {         
                           
                                $paths2= $path.'/images/products/agent_super_admin/small_package/'.$img2;
                            
                                move_uploaded_file($_FILES['field2']['tmp_name'],$paths2);
                                $this->getSmallPackageTable()->updateSmallPackageImage2($id,$img2);
                                
                        }
                        
                    }
                    $this->flashmessenger()->addMessage("Data Added Successfully...");
                    return $this->redirect()->toRoute('agentSuperAdmin/smallPackage');

                }
                
            }
           
            return new ViewModel(array(
                'editSmallSuperAdminPackageData'=>$this->getSmallPackageTable()->editSmallSuperAdminPackageData($id),
                'flashMessages' => $this->flashMessenger()->getMessages(),
            ));  

             
            
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }      
    }

    public function deleteAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $delId= $_POST['delid'];
            if($delId !='')
            {
                $menuData = new SmallPackageModel();
                $path='/var/www/coool/public/images/products/agent_super_admin/small_package/';

                //Delete Image from folder
                if($deletedRecord= $this->getSmallPackageTable()->deleteSmallPackages($delId))
                {
                   
                    foreach ($deletedRecord as $key => $value)
                    {
                        unlink("$path".$value['image2']);
                       
                    }
                    
                }
               
                if($this->getSmallPackageTable()->deleteSmallPackageData($delId))
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
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }

    }


    
}

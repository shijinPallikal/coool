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

 
use Admin\Model\SmallPackageModel;
use Admin\Model\SmallPackageTable;

use Admin\Model\OfferDatesTable;
use Admin\Model\OfferDatesModel;


class SmallPackageController extends AbstractActionController
{

    protected $smallPackageTable;
    protected $offerDatesTable;

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
        if (! $this->authservice)
        {
            $this->authservice = $this->getServiceLocator()->get('AdminAuth');
        }        
        return $this->authservice;
    }

    //Actions
    public function indexAction()
    {   
        if ($this->getAuthService()->hasIdentity())
        {  
            $this->layout('layout/adminDashboardLayout');
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }  
        
    }
    
   public function addAction()
    {
       $config=$this->getServiceLocator()->get('config');
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $request=$this->getRequest();
            if($request->isPost())
            {
                $smallPackageData = new SmallPackageModel();
                $offerDateData= new OfferDatesModel();

                //Current User Id from Session
                $session = new Container('user'); 
                $userId = $session->offsetGet('userId'); 

                $offerDate= explode(',', $request->getPost("pre-select-dates"));
                if($request->getPost("default") == '')
                {
                    //echo "zero";exit;
                    $default= 0;
                }
                else
                {
                    $default= $request->getPost("default");
                    //echo $default; exit;
                }   
                            
                $smallPackageData->setProductTitle($request->getPost('product_title'));
                $smallPackageData->setDefault($default);
                $smallPackageData->setDescription($request->getPost("product_description"));
                $smallPackageData->setUrl($request->getPost("curl"));
                $smallPackageData->setUserId($userId);
                $smallPackageData->setUser('agentadmin');
                $smallPackageData->setArea($request->getPost("area"));
                $smallPackageData->setCreatedOn(date('Y-m-d H:i:s'));
                $lastId=$this->getSmallPackageTable()->saveSmallPackageData($smallPackageData);

                // Packages showing dates insert into another table with Last inserted id;
                $i=0;
                
                for($i=0; $i<= count($offerDate)-1; $i++)
                {
                    $offerDateData->setPackage("small");
                    $offerDateData->setPackageId($lastId);
                    $offerDateData->setOfferDate($offerDate[$i]);

                    $this->getOfferDatesTable()->saveOfferDateDatas($offerDateData);
                }
                
                // $path           ='';
                $path=$config['defaultValues']['upload_path'];
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
                            $paths1= $path.'/images/products/small_package/'.$img1;
                        
                            move_uploaded_file($_FILES['field1']['tmp_name'],$paths1);
                            $this->getSmallPackageTable()->updateSmallPackageImage1($lastId,$img1);
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
                            echo"error";
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
                            $paths2= $path.'/images/products/small_package/'.$img2;
                        
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
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }  

    }

    public function ajaxListAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $viewModel= new ViewModel(array(
                'listAllSmallPackage1' => $this->getSmallPackageTable()->listAllSmallPackageAreaDefault1(),
                'listAllSmallPackage11' => $this->getSmallPackageTable()->listAllSmallPackageAreaDefault11(),
                'listAllSmallPackage2' => $this->getSmallPackageTable()->listAllSmallPackageAreaDefault2(),
                'listAllSmallPackage22' => $this->getSmallPackageTable()->listAllSmallPackageAreaDefault22(),
                'listAllAdminSmallPackage' => $this->getSmallPackageTable()->listAllAdminSmallPackage(),
                'listAllAdminSmallPackage2' => $this->getSmallPackageTable()->listAllAdminSmallPackage2(),
                'listAllSmallPackageDatesArea1' => $this->getOfferDatesTable()->listAllSmallPackageDatesArea1(),
                'listAllSmallPackageDatesArea2' => $this->getOfferDatesTable()->listAllSmallPackageDatesArea2(),
            ));

            $viewModel->setTerminal(true);
            return $viewModel;
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
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
                if($this->getSmallPackageTable()->updateSmallPackageStatusOff($_POST['offId']))
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
                if($this->getSmallPackageTable()->updateSmallPackageStatusOn($_POST['onId']))
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

    public function deleteAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $delId= $_POST['delid'];
           
            if($delId !='')
            {
                $sliderData = new SmallPackageModel();

                
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

    public function editAction()
    {
        $config=$this->getServiceLocator()->get('config');
        if ($this->getAuthService()->hasIdentity())
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

                // Packages showing dates insert into another table with Last inserted id;
                
                $offerDateData= new OfferDatesModel();

                $editSmallPackage = $this->getOfferDatesTable()->listSmallPackageDates($id);
                foreach ($editSmallPackage as $key => $values)
                {
                    $dates[]= $values['offer_date'];
                }
                //print_r($dates);
                
                $offerDate= explode(',', $request->getPost("pre-select-dates"));
                //print_r($offerDate); 
                $difference[] = array_diff_assoc($offerDate,$dates);
                //print_r($difference); 
                //echo count($difference); exit;
                foreach($difference as $rs => $diff)
                {
                    foreach($diff as $rs1 =>$dif)
                    {
                       // print_r($rs1);exit;

                        for($i=$rs1; $i<= $rs1; $i++)
                        {
                            //print_r($dif);exit;
                            $offerDateData->setPackage("small");
                            $offerDateData->setPackageId($id);
                            $offerDateData->setOfferDate($dif);
                            $this->getOfferDatesTable()->saveOfferDateDatas($offerDateData);
                        }
                    }
                }
                
                   // $i=0;
                    
                
                $smallPackageData = new SmallPackageModel();
                //Current User Id from Session
                $session = new Container('user'); 
                $userId = $session->offsetGet('userId');
                
                $smallPackageData->setId($id);
                $smallPackageData->setProductTitle($request->getPost('product_title'));
                $smallPackageData->setDefault($default);
                $smallPackageData->setDescription($request->getPost("product_description"));
                $smallPackageData->setUrl($request->getPost("curl"));
                $smallPackageData->setUserId($userId);
                $smallPackageData->setArea($request->getPost("area"));
                $smallPackageData->setUpdatedOn(date('Y-m-d H:i:s'));
                
                
                // $path           ='';
                $path=$config['defaultValues']['upload_path'];
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
                            $paths1= $path.'/images/products/small_package/'.$img1;
                        
                            move_uploaded_file($_FILES['field1']['tmp_name'],$paths1);
                            //$this->getSmallPackageTable()->($id,$img1);
                            $smallPackageData->setImage1($img1);
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
                            $paths2= $path.'/images/products/small_package/'.$img2;
                        
                            move_uploaded_file($_FILES['field2']['tmp_name'],$paths2);
                            //$this->getSmallPackageTable()->updateSmallPackageImage2($id,$img2);
                            $smallPackageData->setImage2($img2);
                            
                        }
                    }
                    
                }
                //return new ViewModel(array(
                 //   'flashMessages' => $this->flashMessenger()->getMessages(),
                //));
                $this->getSmallPackageTable()->updateSmallPackageData($smallPackageData);
                return $this->redirect()->toRoute('admin/smallPackage');
            }
            return new ViewModel(array(
                'editSmallPackageData'=>$this->getSmallPackageTable()->listSmallPackageData($id),
                'editSmallPackageDates'=>$this->getOfferDatesTable()->listSmallPackageDates($id),
            ));  
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }      
    }
    
}

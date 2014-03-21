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


use Admin\Model\BigPackageModel;
use Admin\Model\BigPackageTable;

use Admin\Model\OfferDatesTable;
use Admin\Model\OfferDatesModel;

class BigPackageController extends AbstractActionController
{

    protected $bigPackageTable;
    protected $offerDatesTable;
    protected $authservice;

    public function getBigPackageTable()
    {
        if(!$this->bigPackageTable)
        {
            $sm= $this->getServiceLocator();
            $this->bigPackageTable = $sm->get('Admin\Model\BigPackageTable'); 
        }
        return $this->bigPackageTable;
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
            $this->flashmessenger()->addMessage("You are not Registered Admin");
            return $this->redirect()->toRoute('admin');
        } 
    }
    
   public function addAction()
    {
       $config = $this->getServiceLocator()->get('config');        
       
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $request=$this->getRequest();
            if($request->isPost())
            {
                $file1  = $this->params()->fromFiles('field1');
                $file2  = $this->params()->fromFiles('field2');
                
                if($file1['size'] > 5.243e+6)
                {
                    $this->flashmessenger()->addMessage("Your Big Image is greater than 5MB file");
                    return $this->redirect()->toRoute('admin/bigPackage/add');
                }
                else if($file2['size'] > 5.243e+6)
                {
                    $this->flashmessenger()->addMessage("Your Small Image is greater than 5MB file");
                    return $this->redirect()->toRoute('admin/bigPackage/add');
                }
                else
                {
                    $bigPackageData = new BigPackageModel();
                    $offerDateData= new OfferDatesModel();

                    //Current User Id from Session
                    $session = new Container('user'); 
                    $userId = $session->offsetGet('userId'); 

                    $offerDate= explode(',', $request->getPost("pre-select-dates"));                
                    $bigPackageData->setProductTitle($request->getPost('product_title'));
                    $bigPackageData->setDefault($request->getPost("default"));
                    $bigPackageData->setDescription($request->getPost("product_description"));
                    $bigPackageData->setUrl($request->getPost("curl"));
                    $bigPackageData->setUserId($userId);
                    $bigPackageData->setUser('agentadmin');
                    $bigPackageData->setCreatedOn(date('Y-m-d H:i:s'));
                    $lastId=$this->getBigPackageTable()->saveBigPackageData($bigPackageData);

                    // Packages showing dates insert into another table with Last inserted id;
                    $i=0;
                    for($i=0; $i<= count($offerDate)-1; $i++)
                    {
                        $offerDateData->setPackage("big");
                        $offerDateData->setPackageId($lastId);
                        $offerDateData->setOfferDate($offerDate[$i]);

                        $this->getOfferDatesTable()->saveOfferDateDatas($offerDateData);
                    }


                    
                    // $path           ='';
                    $path= $config['defaultValues']['upload_path'];
                    if($this->params()->fromFiles('field1') != '')
                    {

                        $file1  = $this->params()->fromFiles('field1');
                        $isFileUploaded = 1;
                        
                        $ext1= explode('.',$file1['name']);
                        $img1= $lastId.'_big.'.$ext1[1];
                        
                        if(!empty($file1['name']))
                        {         
                            $paths1= $path.'/images/products/big_package/'.$img1;
                            move_uploaded_file($_FILES['field1']['tmp_name'],$paths1);
                            $this->getBigPackageTable()->updateBigPackageImage1($lastId,$img1);
                            
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
                                $this->getBigPackageTable()->updateBigPackageImage2($lastId,$img2);
                                
                            }
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
            $this->flashmessenger()->addMessage("Please login");
            return $this->redirect()->toRoute('admin');
        } 

    }

    public function ajaxListAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $viewModel= new ViewModel(array(
                'listAllBigPackage' => $this->getBigPackageTable()->listAllBigPackage(),
                'listAllBigPackageDefault' => $this->getBigPackageTable()->listAllBigPackageDefault(),
                'listAllBigPackageDefaultAdmin' => $this->getBigPackageTable()->listAllBigPackageDefaultAdmin(),

            ));

            $viewModel->setTerminal(true);
            return $viewModel;
        }
        else
        {
            $this->flashmessenger()->addMessage("You are not Registered Admin");
            return $this->redirect()->toRoute('admin');
        } 
    }


    //Stataus to Off
    public function statusAction()
    {
        if ($this->getAuthService()->hasIdentity())
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
        else
        {
            $this->flashmessenger()->addMessage("You are not Registered Admin");
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
        else
        {
            $this->flashmessenger()->addMessage("You are not Registered Admin");
            return $this->redirect()->toRoute('admin');
        } 

    }
    public function deleteDates()
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
                
                $offerDateData= new OfferDatesModel();

                $editBigPackage = $this->getOfferDatesTable()->listBigPackageDates($id);
                foreach ($editBigPackage as $key => $values)
                {
                    $dates[]= $values['offer_date'];
                }
                
                
                $offerDate= explode(',', $request->getPost("pre-select-dates"));
                
                $difference[] = array_diff_assoc($offerDate,$dates);
                
                foreach($difference as $rs => $diff)
                {
                    foreach($diff as $rs1 =>$dif)
                    {
                        for($i=$rs1; $i<= $rs1; $i++)
                        {
                            $offerDateData->setPackage("big");
                            $offerDateData->setPackageId($id);
                            $offerDateData->setOfferDate($dif);
                            $this->getOfferDatesTable()->saveOfferDateDatas($offerDateData);
                        }
                    }
                }
                

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
                $bigPackageData->setUser('agentadmin');
                $bigPackageData->setArea($request->getPost("area"));
                $bigPackageData->setUpdatedOn(date('Y-m-d H:i:s'));
                
                
                // $path           ='';
                $path=$config['defaultValues']['upload_path'];
                if($this->params()->fromFiles('field1') != '')
                {
                    
                    $file1  = $this->params()->fromFiles('field1');
                    
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
                            
                            $bigPackageData->setImage1($img1);
                        }
                    }

                }

                

                if($this->params()->fromFiles('field2') != '')
                {
                    $file2  = $this->params()->fromFiles('field2');
                    $isFileUploaded = 1;
                    
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
                            $paths2= $path.'/images/products/big_package/'.$img2;
                        
                            move_uploaded_file($_FILES['field2']['tmp_name'],$paths2);
                           
                            $bigPackageData->setImage2($img2);
                            
                        }
                    }
                    
                }
                
                $this->getBigPackageTable()->updateBigPackageData($bigPackageData);
                return $this->redirect()->toRoute('admin/bigPackage');
            }
            return new ViewModel(array(
                'editBigPackageData'=>$this->getBigPackageTable()->listBigPackageData($id),
                'editBigPackageDates'=>$this->getOfferDatesTable()->listBigPackageDates($id),
            ));       
        }
        else
        {
            $this->flashmessenger()->addMessage("You are not Registered Admin");
            return $this->redirect()->toRoute('admin');
        }
    }   
    
}

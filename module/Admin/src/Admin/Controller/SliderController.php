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

 
use Admin\Model\SliderModel;
use Admin\Model\SliderTable;

use Admin\Model\SliderColorTable;
use Admin\Model\SliderColorModel;


class SliderController extends AbstractActionController
{

    protected $sliderTable;
    protected $authservice;
    protected $sliderColorTable;

    
    public function getSliderTable()
    {
        if(!$this->sliderTable)
        {
            $sm= $this->getServiceLocator();
            $this->sliderTable = $sm->get('Admin\Model\SliderTable'); 
        }
        return $this->sliderTable;
    }

    public function getSliderColorTable()
    {
        if(!$this->sliderColorTable)
        {
            $sm= $this->getServiceLocator();
            $this->sliderColorTable = $sm->get('Admin\Model\SliderColorTable'); 
        }
        return $this->sliderColorTable;
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
            $session = new Container('language');
            $languageId   = $session->offsetGet('languageId');
            $this->layout()->setVariables(array('languageId' => $languageId));
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
            $session = new Container('language');
            $languageId   = $session->offsetGet('languageId');
            $this->layout()->setVariables(array('languageId' => $languageId));
            $request=$this->getRequest();
            if($request->isPost())
            {
                $sliderData = new SliderModel();
               
                //Current User Id from Session
                $session = new Container('user'); 
                $userId = $session->offsetGet('userId');
                
                $file  = $this->params()->fromFiles('field');
               
                $ext= explode('.',$file['name']);
                
                $link = $request->getPost("link");
                $exLink=substr($link, 0, 7);
                if($exLink == 'http://')
                {
                    $explodeLink=$link;
                }
                else
                {
                    $explodeLink='http://'.$link;
                }
                //echo $request->getPost("c1").'<br>';
                //echo $request->getPost("c2");exit;
                $sliderData->setTitle($request->getPost('image_title'));
                $sliderData->setDescription($request->getPost("image_description"));
                $sliderData->setBackgroundColor($request->getPost("c1"));
                $sliderData->setDiscriptionBackgroundColor($request->getPost("c2"));
                $sliderData->setUrl($explodeLink);
                $sliderData->setUserId($userId);
                $sliderData->setCreatedOn(date('Y-m-d H:i:s'));
                $lastId=$this->getSliderTable()->saveSliderData($sliderData);
                

                $isFileUploaded = 1;
               // $path           ='';
                $path=$config['defaultValues']['upload_path'];
                $img= $lastId.'.'.$ext[1];
                if(!empty($file['name']))
                {         
                    $size = new Size(array('min'=>10, 'max' => 9000000)); //minimum bytes filesize
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $adapter->setValidators(array($size), $file['name']);
                    if (!$adapter->isValid())
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
                        
                        $paths= $path.'/images/slider/'.$img;
                        move_uploaded_file($_FILES['field']['tmp_name'],$paths);
                        $this->getSliderTable()->updateSliderImage($lastId,$img);
                        
                    }
                }
                return $this->redirect()->toRoute('admin/slider');
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
                $sliderData = new SliderModel();

                
                if($this->getSliderTable()->deleteSliderData($delId))
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

    public function ajaxListAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {

            $viewModel = new ViewModel(array(
                'listAllSliderData' => $this->getSliderTable()->listAllSliderData()
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

            $sliderData = new SliderModel();
            //Status off
            if($_POST['offId'] != '')
            {
                if($this->getSliderTable()->updateSliderStatusOff($_POST['offId']))
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
                if($this->getSliderTable()->updateSliderStatusOn($_POST['onId']))
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
        $config=$this->getServiceLocator()->get('config');
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $session = new Container('language');
            $languageId   = $session->offsetGet('languageId');
            $this->layout()->setVariables(array('languageId' => $languageId));
            $id= (int) $this->params()->fromRoute('id');
            $request = $this->getRequest();
                    
            if($request->isPost())
            {
                $sliderData = new SliderModel();
               
                //Current User Id from Session
                $session = new Container('user'); 
                $userId = $session->offsetGet('userId');
                
                $link = $request->getPost("link");
                $exLink=substr($link, 0, 7);
                if($exLink == 'http://')
                {
                    $explodeLink=$link;
                }
                else
                {
                    $explodeLink='http://'.$link;
                }

                if($this->params()->fromFiles('field') != '')
                {
                    $isFileUploaded = 1;
                    //for Server
                    // $path           ='';
                    //local Path
                    $path=$config['defaultValues']['upload_path'];
                    

                    $file  = $this->params()->fromFiles('field');
                    //print_r($file); exit;           
                    $ext= explode('.',$file['name']);
                                    
                    $img= $id.'.'.$ext[1];
                    //echo $img; exit;
                    if(!empty($file['name']))
                    {         
                        $size = new Size(array('min'=>10, 'max' => 9000000)); //minimum bytes filesize
                        $adapter = new \Zend\File\Transfer\Adapter\Http();
                        $adapter->setValidators(array($size), $file['name']);
                        if (!$adapter->isValid())
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
                            $imageName= $request->getPost('imgName');
                            if($imageName!= '')
                            {
                               unlink($path.'/images/slider/'.$imageName);
                            }
                            $paths= $path.'/images/slider/'.$img;
                            move_uploaded_file($_FILES['field']['tmp_name'],$paths);
                            $sliderData->setImage($img);                       
                        }
                    }
                    
                }
                $sliderData->setId($id);
                $sliderData->setTitle($request->getPost('image_title'));
                $sliderData->setDescription($request->getPost("image_description"));
                $sliderData->setUrl($explodeLink);
                $sliderData->setUserId($userId);
                $sliderData->setCreatedOn(date('Y-m-d H:i:s'));
                $this->getSliderTable()->updateAllSliderData($sliderData);
                return $this->redirect()->toRoute('admin/slider');    
            }
             return new ViewModel(array(
                'editSliderData'=>$this->getSliderTable()->updateSliderData($id),
            ));
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
    }
    
    public function colorAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $request=$this->getRequest();
            if($request->isPost())
            {
                $sliderColorData = new SliderColorModel();
               
                
                $sliderColorData->setBgColor($request->getPost("c1"));
                $sliderColorData->setDiscriptionColor($request->getPost("c2"));
                
                $this->getSliderColorTable()->saveSliderColorData($sliderColorData);
                
                return $this->flashmessenger()->addMessage("Please login...");
                return $this->redirect()->toRoute('admin/slider');
            }
            
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }

    }

    public function colorListAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $viewModel = new ViewModel(array(
                'listAllSliderColorData' => $this->getSliderColorTable()->listAllSliderColorData()
            ));
            return $viewModel;
        }

    }

    public function colorEditAction()
    {
        $config=$this->getServiceLocator()->get('config');
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $id= (int) $this->params()->fromRoute(id);
            $request = $this->getRequest();
                    
            if($request->isPost())
            {
                $sliderColorData = new SliderColorModel();
               
                $sliderColorData->setId($id);
                $sliderColorData->setBgColor($request->getPost("c1"));
                $sliderColorData->setOpacity($request->getPost("opacity"));
                $sliderColorData->setDiscriptionColor($request->getPost("c2"));

                $path=$config['defaultValues']['upload_path'];
                if($this->params()->fromFiles('f1') != '')
                {
                    $file  = $this->params()->fromFiles('f1');
                    $ext= explode('.',$file['name']);
                    $img= $id.'.'.$ext[1];
                    
                    if(!empty($file['name']))
                    {         
                        $paths= $path.'/images/slider/pattern/'.$img;
                        
                        move_uploaded_file($_FILES['f1']['tmp_name'],$paths);
                    }
                }

                $sliderColorData->setPattern($img);
                $this->getSliderColorTable()->updateAllSliderColorData($sliderColorData);
                return $this->redirect()->toRoute('admin/slider/colorList');    
            }
             return new ViewModel(array(
                'editSliderColorData'=>$this->getSliderColorTable()->editSliderColorData($id),
            ));
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
    }

    public function ajaxColorListAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {

            $viewModel = new ViewModel(array(
                'listAllSliderColorData' => $this->getSliderColorTable()->listAllSliderColorData()
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

    //Pattern Stataus to Off
    public function patternStatusAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {

            $sliderColorData = new SliderColorModel();
            //Status off
            if($_POST['offId'] != '')
            {
                if($this->getSliderColorTable()->updateSliderPatternStatusOff($_POST['offId']))
                {     
                    echo "Pattern Status Edited SuccessFully....";exit;
                }
                else
                {
                    echo "You can't Change Status....";exit;
                }
            }
            //Status On
            if($_POST['onId'] != '')
            {
                if($this->getSliderColorTable()->updateSliderPatternStatusOn($_POST['onId']))
                {     
                    echo "Pattern Status Edited SuccessFully....";exit;
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

    public function colorStatusAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {

            $sliderColorData = new SliderColorModel();
            //Status off
            if($_POST['offId'] != '')
            {
                if($this->getSliderColorTable()->updateSliderColorStatusOff($_POST['offId']))
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
                if($this->getSliderColorTable()->updateSliderColorStatusOn($_POST['onId']))
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
}
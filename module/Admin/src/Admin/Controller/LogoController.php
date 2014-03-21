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

 
use Admin\Model\LogoModel;
use Admin\Model\LogoTable;


class LogoController extends AbstractActionController
{

    protected $logoTable;
    protected $authservice;

    public function getLogoTable()
    {
        if(!$this->logoTable)
        {
            $sm= $this->getServiceLocator();
            $this->logoTable = $sm->get('Admin\Model\LogoTable'); 
        }
        return $this->logoTable;
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
            $viewModel = new ViewModel(array(
                'flashMessages' => $this->flashMessenger()->getMessages(),
            ));
            return $viewModel;
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
                $file  = $this->params()->fromFiles('logo');
                if($file['size'] > 5.243e+6)
                {
                    $this->flashmessenger()->addMessage("You can upload below 5MB file");
                    return $this->redirect()->toRoute('admin/logo/add');
                }
                else
                {

                    $logoData = new LogoModel();
                    
                    //Current User Id from Session
                    $session = new Container('user'); 
                    $userId = $session->offsetGet('userId');
                    
                    $logoData->setShowTitle($request->getPost('company_title'));
                    $logoData->setUserId($userId);
                    $lastId=$this->getLogoTable()->saveLogoData($logoData);
                    //echo $lastId; exit;
                    $path=$config['defaultValues']['upload_path'];
                    if($this->params()->fromFiles('logo') != '')
                    {
                        $file  = $this->params()->fromFiles('logo');
                        
                        $isFileUploaded = 1;
                        
                        $ext= explode('.',$file['name']);
                        $img= $lastId.'.'.$ext[1];
                        
                        if(!empty($file['name']))
                        {         
                            $paths= $path.'/images/products/logo/'.$img;
                            move_uploaded_file($_FILES['logo']['tmp_name'],$paths);
                            $this->getLogoTable()->updateLogoTable($lastId,$img);
                            
                        }

                    }
                }
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
                'listallLogo' => $this->getLogoTable()->listAllLogo(),
                'flashMessages' => $this->flashMessenger()->getMessages()

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
                $file  = $this->params()->fromFiles('logo');
                if($file['size'] > 5.243e+6)
                {
                    
                    $this->flashmessenger()->addMessage("You can upload below 5MB file");
                    return $this->redirect()->toRoute('admin/logo/add');
                }
                else
                {
                    
                    $logoData = new LogoModel();
                    
                    //Current User Id from Session
                    $session = new Container('user'); 
                    $userId = $session->offsetGet('userId');
                    
                    $logoData->setShowTitle($request->getPost('company_title'));
                    $logoData->setId($id);
                    $logoData->setUserId($userId);
                    $lastId=$this->getLogoTable()->updateLogoData($logoData);
                    //echo $lastId; exit;
                    $path=$config['defaultValues']['upload_path'];
                    if($this->params()->fromFiles('logo') != '')
                    {
                        $file  = $this->params()->fromFiles('logo');
                        
                        $isFileUploaded = 1;
                        
                        $ext= explode('.',$file['name']);
                        $img= $id.'.'.$ext[1];
                        
                        if(!empty($file['name']))
                        {         
                            $paths= $path.'/images/products/logo/'.$img;
                            move_uploaded_file($_FILES['logo']['tmp_name'],$paths);
                            $this->getLogoTable()->updateLogoTable($id,$img);
                            
                        }

                    }

                    $this->flashmessenger()->addMessage("Datas Edited successfully..");
                    return $this->redirect()->toRoute('admin/logo');
                }
            }
             return new ViewModel(array(
                'editLogoData' =>$this->getLogoTable()->editLogoData($id),
            ));
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
        
    }


    
}

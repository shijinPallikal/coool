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

 
use Admin\Model\LogoModel;
use Admin\Model\LogoTable;

use Admin\Model\LanguagesModel;
use Admin\Model\LanguagesTable;


class LanguagesController extends AbstractActionController
{

    protected $logoTable;
    protected $authservice;
    protected $languagesTable;



    public function getLogoTable()
    {
        if(!$this->logoTable)
        {
            $sm= $this->getServiceLocator();
            $this->logoTable = $sm->get('Admin\Model\LogoTable'); 
        }
        return $this->logoTable;
    }
    public function getLanguagesTable()
    {
        if(!$this->languagesTable)
        {
            $sm= $this->getServiceLocator();
            $this->languagesTable = $sm->get('Admin\Model\LanguagesTable'); 
        }
        return $this->languagesTable;
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
        if($this->getAuthService()->hasIdentity())
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
        if ($this->getAuthService()->hasIdentity())
        {      
            $this->layout('layout/adminDashboardLayout');

            $request=$this->getRequest();
            if($request->isPost())
            {
                $languagesData = new LanguagesModel();
                                
                $languagesData->setLanguages($request->getPost('lan'));
                $lastId=$this->getLanguagesTable()->saveLanguageData($languagesData);
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
        $viewModel= new ViewModel(array(
            'languagesDatas' => $this->getLanguagesTable()->listLanguagesDatas(),
        ));

        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function ajaxAdminListAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $viewModel= new ViewModel(array(
                'languagesDatas' => $this->getLanguagesTable()->listLanguagesSessionDatas(),
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

    public function statusAction()
    {
        //Status off
        if($_POST['offId'] != '')
        {
            if($this->getLanguagesTable()->updateLanguagesOff($_POST['offId']))
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

            if($this->getLanguagesTable()->updateLanguagesOn($_POST['onId']))
            {     
                echo "Status Edited SuccessFully....";exit;
            }
            else
            {
                echo "You can't Change Status....";exit;
            }
        }
        
    }

    public function editAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $id= (int) $this->params()->fromRoute(id);
            $this->layout('layout/adminDashboardLayout');

            $request=$this->getRequest();
            if($request->isPost())
            {
                //echo "hAI IM HERE..";exit;
                $languagesData = new LanguagesModel();

                $languagesData->setId($id);                
                $languagesData->setLanguages($request->getPost('lan'));
                $this->getLanguagesTable()->updateLanguageData($languagesData);
                $this->flashmessenger()->addMessage("Datas Edited successfully..");
                return $this->redirect()->toRoute('admin/languages');
            }
             return new ViewModel(array(
                'editLanguagesData' =>$this->getLanguagesTable()->editLanguagesData($id),
            ));
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
        
    }

   
    
}

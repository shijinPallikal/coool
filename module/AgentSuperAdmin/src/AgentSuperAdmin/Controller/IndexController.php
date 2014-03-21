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

use Admin\Model\LoginModel;
use Admin\Model\LoginTable;

use Admin\Model\LogoModel;
use Admin\Model\LogoTable;


class IndexController extends AbstractActionController
{
	protected $authService;
    protected $loginTable;
    protected $logoTable;

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
        if (! $this->authService)
        {
            $this->authService = $this->getServiceLocator()->get('AgentSuperAdminAuth');
        }        
        return $this->authService;
    }

    public function getLoginTable()
    {
        if(!$this->loginTable)
        {
            $sm= $this->getServiceLocator();
            $this->loginTable = $sm->get('Admin\Model\LoginTable'); 
        }
        return $this->loginTable;
    }

    public function indexAction()
    {
        
            $this->layout('layout/layoutAgentSuperAdmin');
        	return new ViewModel(array(
                'flashMessages' => $this->flashMessenger()->getMessages(),
            ));
        
    }


    public function agentSuperAdminAuthenticateAction()
    {
            $this->layout('layout/layoutAgentSuperAdmin');
            $request = $this->getRequest();
            if ($request->isPost())
            {
                if($request->getPost('username') && $request->getPost('password') != '' )
                {
                    $s=$this->getAuthService()->getAdapter()
                                              ->setIdentity($request->getPost('username'))
                                              ->setCredential($request->getPost('password'));
                         
                    $result = $this->getAuthService()->authenticate();
                    if ($result->isValid())
                    {     
                        $adminUserResult = $this->getLoginTable()->getUserDetails($request->getPost('username'), $request->getPost('password'));                   
                        $adminUser = $adminUserResult->current();
                        
                        $session = new Container('agentSuperAdmin');
                        $session->offsetSet('agentSuperAdminId',     $adminUser['id']);
                        $session->offsetSet('agentSuperAdminName', $adminUser['username']);
                        $session->offsetSet('agentSuperAdminStatus', $adminUser['status']);
                        $agentSuperAdminId   = $session->offsetGet('agentSuperAdminId');
                        
                        $agentSuperAdminName = $session->offsetGet('agentSuperAdminName');
                        $agentSuperAdminStatus = $session->offsetGet('agentSuperAdminStatus');
                        $ip       = $_SERVER['REMOTE_ADDR'];
                        $this->getLoginTable()->updateUserLogin($agentSuperAdminId,$ip);
                        if($agentSuperAdminStatus == 2)
                        {
                            return $this->redirect()->toRoute('agentSuperAdmin/agentSuperAdminDashboard');
                        }
                        else
                        {
                            $this->flashmessenger()->addMessage("Your are not Active Super Admin");
                            return $this->redirect()->toRoute('agentSuperAdmin');
                        }   
                    }
                    else
                    {
                        $this->flashmessenger()->addMessage("You are not Registered Agent Super Admin");
                        return $this->redirect()->toRoute('agentSuperAdmin');
                    }
                }
                else
                {
                    $this->flashmessenger()->addMessage("Username or Password is Not correct");
                    return $this->redirect()->toRoute('agentSuperAdmin');
                }     
            }
        
    }

    public function agentSuperAdminDashboardAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/agentSuperAdminDashboardLayout');
        

            $viewModel= new ViewModel(array(
                'listallLogo' => $this->getLogoTable()->listAllLogoForAdmin(),
            ));

            return $viewModel;
        }
        else
        {
            return $this->redirect()->toRoute('agentSuperAdmin');         
        }
             
    }

    public function ajaxList()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/agentSuperAdminDashboardLayout');
        
            $viewModel = new ViewModel(array(
                'listCountryData' => $this->getCountryTable()->listAllLogoForAdmin(),
                'flashMessages' => $this->flashMessenger()->getMessages()

            ));

            $viewModel->setTerminal(true);
            return $viewModel;
        }
        else
        {
            return $this->redirect()->toRoute('agentSuperAdmin');         
        }
    }

    public function superAdminLogoutAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $this->getAuthService()->clearIdentity();                
            $session = new Container('agentSuperAdmin');
            $session->getManager()->getStorage()->clear('agentSuperAdmin');
            unset($_SESSION['agentSuperAdmin']);
        
            $this->flashmessenger()->addMessage("You've been logged out...");
            return $this->redirect()->toRoute('agentSuperAdmin');
        }
        else
        {
            return $this->redirect()->toRoute('agentSuperAdmin');         
        }
    }
    
}

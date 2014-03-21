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

 
use Admin\Model\LoginModel;
use Admin\Model\LoginTable;

use Admin\Model\LanguagesModel;
use Admin\Model\LanguagesTable;


class IndexController extends AbstractActionController
{

    protected $authservice;
    protected $loginTable;
    protected $languagesTable;

    public function getAuthService()
    {
        if (! $this->authservice)
        {
            $this->authservice = $this->getServiceLocator()->get('AdminAuth');
        }        
        return $this->authservice;
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

    public function getLanguagesTable()
    {
        if(!$this->languagesTable)
        {
            $sm= $this->getServiceLocator();
            $this->languagesTable = $sm->get('Admin\Model\LanguagesTable'); 
        }
        return $this->languagesTable;
    }


    //Actions
    public function indexAction()
    {
        $this->layout('layout/layoutAdmin');
        return new ViewModel(array(
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));
        
    }
    
    public function adminAuthenticateAction()
    {
        $this->layout('layout/layoutAdmin');
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
                        
                    $session = new Container('user');
                    $session->offsetSet('userId',     $adminUser['id']);
                    $session->offsetSet('userName', $adminUser['username']);
                    $session->offsetSet('userStatus', $adminUser['status']);
                    $userId   = $session->offsetGet('userId');
                    $userName = $session->offsetGet('userName');
                    $userStatus = $session->offsetGet('userStatus');
                    $ip       = $_SERVER['REMOTE_ADDR'];
                                 

                    //Language into Session
                    $adminLanguageSession = $this->getLanguagesTable()->listLanguagesSessionDatas();
                    
                    $adminLanguage = $adminLanguageSession->current();
                    $session = new Container('language');
                    $session->offsetSet('languageId',     $adminLanguage['id']);
                    $languageId   = $session->offsetGet('languageId');
                                    
                    $this->getLoginTable()->updateUserLogin($userId,$ip);
                    if($userStatus == 1)
                    {
                        return $this->redirect()->toRoute('admin/adminDashboard');
                    }
                    else
                    {
                        $this->flashmessenger()->addMessage("Your are not Active  Admin");
                        return $this->redirect()->toRoute('admin');
                    }   
                }
                else
                {
                    $this->flashmessenger()->addMessage("You are not Registered Admin");
                    return $this->redirect()->toRoute('admin');
                }
            }
            else
            {
                $this->flashmessenger()->addMessage("Username or Password is Not correct");
                return $this->redirect()->toRoute('admin');
            }       
            
        }
        
    }

    public function adminDashboardAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            if ($this->getAuthService()->hasIdentity())
            { 
                $session = new Container('language');
                $languageId   = $session->offsetGet('languageId');
                //echo $languageId; exit;

                $this->layout('layout/adminDashboardLayout');
                $this->layout()->setVariables(array('languageId' => $languageId));
                
                $viewModel= new ViewModel(array(
                    'languagesDatas' => $this->getLanguagesTable()->listLanguagesDatas(),
                ));
                return $viewModel;   
            }
            else
            {
                return $this->redirect()->toRoute('admin');         
            }
        }
        else
        {
            return $this->redirect()->toRoute('admin');         
        }
    }

    public function adminLogoutAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $this->getAuthService()->clearIdentity();                
            $session = new Container('user');
            $session->getManager()->getStorage()->clear('user');
            unset($_SESSION['user']);
        
            $this->flashmessenger()->addMessage("You've been logged out...");
            return $this->redirect()->toRoute('admin');
        }
        else
        {
            return $this->redirect()->toRoute('admin');         
        }
    }
}

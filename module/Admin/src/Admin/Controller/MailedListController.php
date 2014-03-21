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

 
use Admin\Model\UserContactsTable;
use Admin\Model\UserContactsModel;

use Admin\Model\UserEmailModel;
use Admin\Model\UserEmailTable;


class MailedListController extends AbstractActionController
{

    protected $contactsTable;
    protected $userEmailTable;
    

    public function getContactUserTable()
    {
        if(!$this->contactsTable)
        {
            $sm= $this->getServiceLocator();
            $this->contactsTable = $sm->get('Admin\Model\UserContactsTable'); 
        }
        return $this->contactsTable;
    }
    
    public function getAuthService()
    {
        if (! $this->authservice)
        {
            $this->authservice = $this->getServiceLocator()->get('AdminAuth');
        }        
        return $this->authservice;
    }

    public function getUserEmailTable()
    {
        if(!$this->userEmailTable)
        {
            $sm= $this->getServiceLocator();
            $this->userEmailTable = $sm->get('Admin\Model\UserEmailTable'); 
        }
        return $this->userEmailTable;
    }

    //Actions
    public function indexAction()
    {     
        if($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $viewModel = new ViewModel(array(
                'contactUserTable' => $this->getContactUserTable()->getData(),
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

    public function mailedSettingsAction()
    {     
        if($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $viewModel = new ViewModel(array(
                'contactUserTable' => $this->getContactUserTable()->getData(),
                'useremail' => $this->getUserEmailTable()->ListUserEmail(),
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

    public function editAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $id= (int) $this->params()->fromRoute(id);
            $request = $this->getRequest();
                    
            if($request->isPost())
            {
                $emailData = new UserEmailModel();
                
                
                    $emailData->setId($id);
                    $emailData->setEmail($request->getPost('email'));
                    
                    $this->getUserEmailTable()->updateEmailData($emailData);

                    
                    $this->flashmessenger()->addMessage("Datas Updated successfully..");
                    return $this->redirect()->toRoute('admin/mailedList/mailedSettings');
                  
            }
             return new ViewModel(array(
                 'useremail' => $this->getUserEmailTable()->ListUserEmail(),
            ));
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
        
    }
}

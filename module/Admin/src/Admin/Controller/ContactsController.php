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


use Admin\Model\CountryModel;
use Admin\Model\CountryTable;
 
use Admin\Model\ContactsModel;
use Admin\Model\ContactsTable;

use Admin\Model\PhoneModel;
use Admin\Model\PhoneTable;

use Admin\Model\EmailModel;
use Admin\Model\EmailTable;

class ContactsController extends AbstractActionController
{

    protected $contactsTable;
    protected $emailTable;
    protected $phoneTable;
    protected $countryTable;
    protected $authservice;


    public function getCountryTable()
    {
        if(!$this->countryTable)
        {
            $sm= $this->getServiceLocator();
            $this->countryTable = $sm->get('Admin\Model\CountryTable'); 
        }
        return $this->countryTable;
    }

    public function getContactsTable()
    {
        if(!$this->contactsTable)
        {
            $sm= $this->getServiceLocator();
            $this->contactsTable = $sm->get('Admin\Model\ContactsTable'); 
        }
        return $this->contactsTable;
    }

    public function getEmailTable()
    {
    	if(!$this->emailTable)
    	{
    		$sm = $this->getServiceLocator();
       		$this->emailTable = $sm->get('Admin\Model\EmailTable');	
    	}
    	return $this->emailTable;
    }
    public function getPhoneTable()
    {
    	if(!$this->phoneTable)
    		{
    			$sm = $this->getServiceLocator();
       			$this->phoneTable = $sm->get('Admin\Model\PhoneTable');	
    		}
    			return $this->phoneTable;
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
                'flashMessages' => $this->flashMessenger()->getMessages()
            ));
            return $viewModel;
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login");
            return $this->redirect()->toRoute('admin');
        } 
    }

   public function addAction()
    {   
        if ($this->getAuthService()->hasIdentity())
        {     
            $this->layout('layout/adminDashboardLayout');

            $request=$this->getRequest();
            //To get All Array datas
    		$postData = $this->getRequest()->getPost()->toArray();

            if($request->isPost())
            {
            	
                $contactsData   = new ContactsModel();
               
                //Current User Id from Session
                $session = new Container('user'); 
                $userId = $session->offsetGet('userId');

                           
                $contactsData->setCountryId($request->getPost('country'));
                $contactsData->setUserId($userId);
                $contactsData->setTitle($request->getPost('country'));
                $contactsData->setDescription($request->getPost('description'));
                $contactsData->setPhone($request->getPost('phone'));
                $contactsData->setServiceEmail($request->getPost('service'));
                $contactsData->setInfoEmail($request->getPost('info')); 
                $contactsData->setStatus('1');
                $lastId=$this->getContactsTable()->saveContactsData($contactsData);
                
        	

                $viewModel = new ViewModel(array(
                'flashMessages' => $this->flashMessenger()->getMessages()
            	));
            	return $viewModel;

            }

            $viewModel = new ViewModel(array(
                'country' => $this->getCountryTable()->getAllCountry(),
            ));
            return $viewModel;
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
    	
            $viewModel = new ViewModel(array(
                'listAllContact' => $this->getContactsTable()->listAllData(),
                'flashMessages' => $this->flashMessenger()->getMessages()

            ));

            $viewModel->setTerminal(true);
            return $viewModel;
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login");
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
                $contactsData   = new ContactsModel();
               
                //Current User Id from Session
                $session = new Container('user'); 
                $userId = $session->offsetGet('userId');

                $contactsData->setId($id);           
                $contactsData->setCountryId($request->getPost('country'));
                $contactsData->setUserId($userId);
                $contactsData->setTitle($request->getPost('title'));
                $contactsData->setDescription($request->getPost('description'));
                $contactsData->setPhone($request->getPost('phone'));
                $contactsData->setServiceEmail($request->getPost('service'));
                $contactsData->setInfoEmail($request->getPost('info')); 
                $lastId=$this->getContactsTable()->updateContactsData($contactsData);
                
                $this->flashmessenger()->addMessage("Datas Updated successfully..");
                return $this->redirect()->toRoute('admin/contacts');
                  
            }
             return new ViewModel(array(
                'editContactData'=>$this->getContactsTable()->editContactData($id),
                'country' => $this->getCountryTable()->getAllCountry()
            ));
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login");
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
                //echo $_POST['offId']; exit;
                if($this->getContactsTable()->updateContactsStatusOff($_POST['offId']))
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
                //echo $_POST['onId']; exit;
                if($this->getContactsTable()->updateContactsStatusOn($_POST['onId']))
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
            $this->flashmessenger()->addMessage("Please login");
            return $this->redirect()->toRoute('admin');
        } 
        
    }

    /*public function deleteAction()
    {
        $delId= $_POST['delid'];
        if($delId !='')
        {          
            if($this->getCountryTable()->deleteCountryData($delId))
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
            //echo $request->getPost('country'); exit;
            $countryData = new CountryModel();
            
            //Current User Id from Session
            $session = new Container('user'); 
            $userId = $session->offsetGet('userId');
            
            $countryData->setId($id);
            $countryData->setCountry($request->getPost('country'));
            $countryData->setUserId($userId);
            $this->getCountryTable()->updateCountryData($countryData);

            $this->flashmessenger()->addMessage("Datas Added successfully..");
            return $this->redirect()->toRoute('admin/country');
        }
         return new ViewModel(array(
            'editCountryData' =>$this->getCountryTable()->editCountryData($id),
        ));
        
    }*/


    
}

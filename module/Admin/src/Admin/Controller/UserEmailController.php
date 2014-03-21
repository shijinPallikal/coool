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


use Admin\Model\UserEmailModel;
use Admin\Model\UserEmailTable;


class UserEmailController extends AbstractActionController
{

    protected $userEmailTable;
   
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
        $this->layout('layout/adminDashboardLayout');
        $viewModel = new ViewModel(array(
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));
        return $viewModel;
    }

   public function addAction()
    {        
        $this->layout('layout/adminDashboardLayout');

        $request=$this->getRequest();
        //To get All Array datas
		$postData = $this->getRequest()->getPost()->toArray();

        if($request->isPost())
        {
        	
            $userEmailData   = new UserEmailModel();
           
            //Current User Id from Session
            $session = new Container('user'); 
            $userId = $session->offsetGet('userId');

                       
            $userEmailData->setEmail($request->getPost('email'));
            $userEmailData->setUserId($userId);
            $userEmailData->setCreatedOn(date('Y-m-d')); 
            $userEmailData->setStatus('1');
            $lastId=$this->getUserEmailTable()->saveUserEmailData($userEmailData);
            
            $this->flashmessenger()->addMessage("Datas Added successfully..");
            return $this->redirect()->toRoute('admin/userEmail');

        }

    }

   public function ajaxListAction()
    {
    	
        $viewModel = new ViewModel(array(
            'listAllData' => $this->getUserEmailTable()->listAllData(),
            'flashMessages' => $this->flashMessenger()->getMessages()

        ));

        $viewModel->setTerminal(true);
        return $viewModel;
    }

    //Stataus to Off
    public function statusAction()
    {
        //Status off
        if($_POST['offId'] != '')
        {
            //echo $_POST['offId']; exit;
            if($this->getUserEmailTable()->updateUserEmailStatusOff($_POST['offId']))
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
            if($this->getUserEmailTable()->updateUserEmailStatusOn($_POST['onId']))
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
        $this->layout('layout/adminDashboardLayout');
        $id= (int) $this->params()->fromRoute(id);
        $request = $this->getRequest();
                
        if($request->isPost())
        {
            $userEmailData   = new UserEmailModel();
           
            //Current User Id from Session
            $session = new Container('user'); 
            $userId = $session->offsetGet('userId');

            $userEmailData->setId($id);           
            $userEmailData->setEmail($request->getPost('email'));
            $userEmailData->setUserId($userId);
            $userEmailData->setUpdatedOn(date('Y-m-d')); 
            $this->getUserEmailTable()->updateUserEmailData($userEmailData);

            $this->flashmessenger()->addMessage("Email Edited successfully..");
            return $this->redirect()->toRoute('admin/userEmail');
              
        }
         return new ViewModel(array(
            'editUserEmailData'=>$this->getUserEmailTable()->editUserEmailData($id)
        ));
        
    }

    /* public function deleteAction()
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

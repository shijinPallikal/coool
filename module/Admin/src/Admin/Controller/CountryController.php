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


class CountryController extends AbstractActionController
{

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
                $countryData = new CountryModel();
                
                //Current User Id from Session
                $session = new Container('user'); 
                $userId = $session->offsetGet('userId');
                
                $countryData->setCountry($request->getPost('country'));
                $countryData->setUserId($userId);
                $lastId=$this->getCountryTable()->saveCountryData($countryData);
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
                'listCountryData' => $this->getCountryTable()->listAllCountryData(),
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

    //Stataus to Off
    public function statusAction()
    {
        if ($this->getAuthService()->hasIdentity())
        { 
            $countryData = new CountryModel();
            //Status off
            if($_POST['offId'] != '')
            {
                //echo $_POST['offId']; exit;
                if($this->getCountryTable()->updateCountryStatusOff($_POST['offId']))
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
                if($this->getCountryTable()->updateCountryStatusOn($_POST['onId']))
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
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
        
    }


    
}

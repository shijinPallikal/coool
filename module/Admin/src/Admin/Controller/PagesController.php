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
use Zend\Session\Storage\SessionStorage;
use Zend\Session\SessionManager;

use Admin\Model\PagesModel;
use Admin\Model\PagesTable;

class PagesController extends AbstractActionController
{
	protected $pagesTable;
    protected $authservice;

	//To get table
	public function getPagesTable()
	{
            if(!$this->pagesTable)
            {
                    $sm= $this->getServiceLocator();
                    $this->pagesTable= $sm->get('admin\Model\PagesTable');
            }
            return $this->pagesTable;
	}

    public function getAuthService()
    {
        if (!$this->authservice)
        {
            $this->authservice = $this->getServiceLocator()->get('AdminAuth');
        }        
        return $this->authservice;
    }



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
        else{
               $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
	}

	public function addAction()
	{
        if ($this->getAuthService()->hasIdentity())
        {
    		$this->layout('layout/adminDashboardLayout');
    		$request= $this->getRequest();
    		if($request->isPost())
    		{
    			$pagesData= new PagesModel();

                    //Current User Id from Session
                    $session = new Container('user'); 
                    $userId = $session->offsetGet('userId');
        			$pagesData->setTitle($request->getPost('title'));
                    $pagesData->setSubTitle($request->getPost('sub_title'));
        			$pagesData->setUser($userId);
                    $pagesData->setUrl($request->getPost('url'));
                    $pagesData->setDescription(strip_tags(trim($request->getPost('dis'))));
        			$pagesData->setStatus('0');
        			$pagesData->setCreatedOn(date('Y-m-d H:i:s'));

                    $this->getPagesTable()->savePagesDatas($pagesData);
                    $this->flashmessenger()->addMessage("Datas Added successfully..");
                    return $this->redirect()->toRoute('admin/pages');
            }

                
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
        
	}

    public function ajaxListAction(){
        if ($this->getAuthService()->hasIdentity())
        {

            $viewModel = new ViewModel(array(
                'listAllPagesData' => $this->getPagesTable()->listAllPagesData(),
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
            $pagesData = new PagesModel();
            //Status off
            if($_POST['offId'] != '')
            {
                if($this->getPagesTable()->updatePageStatusOff($_POST['offId']))
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
                if($this->getPagesTable()->updatePageStatusOn($_POST['onId']))
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
        if($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $id= (int) $this->params()->fromRoute(id);
            $request = $this->getRequest();
                    
            if($request->isPost())
            {
                $pagesData = new PagesModel();
                
                    $session = new Container('user'); 
                    $userId = $session->offsetGet('userId');
                    $pagesData->setId($id);
                    $pagesData->setTitle($request->getPost('title'));
                    $pagesData->setSubTitle($request->getPost('sub_title'));
                    $pagesData->setUser($userId);
                    $pagesData->setUrl($request->getPost('url'));
                    $pagesData->setDescription(strip_tags(trim($request->getPost('dis'))));
                    $pagesData->setUpdatedOn(date('Y-m-d H:i:s'));

                    $this->getPagesTable()->updatePagesDatas($pagesData);
                    $this->flashmessenger()->addMessage("Datas Updated successfully..");
            		return $this->redirect()->toRoute('admin/pages');       
            }
             return new ViewModel(array(
                'editPageData'=>$this->getPagesTable()->editPageData($id),
            ));
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
        
    }
}
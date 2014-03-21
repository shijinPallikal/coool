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

use Admin\Model\MenuModel;
use Admin\Model\MenuTable;

use Admin\Model\LanguagesTable;
use Admin\Model\LanguagesModel;

class MenuController extends AbstractActionController
{
    protected $menuTable;
    protected $authservice;
    protected $languagesTable;

	//To get table
	public function getMenuTable()
	{
            if(!$this->menuTable)
            {
                $sm= $this->getServiceLocator();
                $this->menuTable= $sm->get('admin\Model\MenuTable');
            }
            return $this->menuTable;
	}

    public function getAuthService()
    {
        if (! $this->authservice)
        {
            $this->authservice = $this->getServiceLocator()->get('AdminAuth');
        }        
        return $this->authservice;
    }
    public function getLanguages()
    {
        if(!$this->languagesTable)
        {
            $sm= $this->getServiceLocator();
            $this->languagesTable= $sm->get('admin\Model\LanguagesTable');
        }
        return $this->languagesTable;
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
		$config=$this->getServiceLocator()->get('config');
        if ($this->getAuthService()->hasIdentity())
        {
    		$this->layout('layout/adminDashboardLayout');
    		$request= $this->getRequest();
    		if($request->isPost())
    		{
    			$menuData= new MenuModel();

                $file  = $this->params()->fromFiles('menu_page_image');
                if($file['size'] > 5.243e+6)
                {
                    $this->flashmessenger()->addMessage("You can upload below 5MB file");
                    return $this->redirect()->toRoute('admin/menu/add');
                }
                else
                {
                    //Current User Id from Session
                    $session = new Container('user'); 
                    $userId = $session->offsetGet('userId');
        			$menuData->setMenuName($request->getPost(menu_title));
                    $menuData->setUrl($request->getPost(menu_url));
                    $menuData->setLanguage($request->getPost('lan'));
        			$menuData->setUserId($userId);
        			$menuData->setStatus('0');
        			$menuData->setCreatedOn(date('Y-m-d H:i:s'));

                    //Display Order setting

                    $maxId= $this->getMenuTable()->menuMaxId();
                    
                    $menuData->setOrder($maxId+1);
        			$lastId= $this->getMenuTable()->saveMenuDatas($menuData);

                    $path=$config['defaultValues']['upload_path'];
                    if($this->params()->fromFiles('menu_page_image') != '')
                    {
                        $file  = $this->params()->fromFiles('menu_page_image');
                        
                        $isFileUploaded = 1;
                        
                        $ext= explode('.',$file['name']);
                        $img= $lastId.'.'.$ext[1];
                        
                        if(!empty($file['name']))
                        {         
                            $paths= $path.'/images/products/menu/'.$img;
                            move_uploaded_file($_FILES['menu_page_image']['tmp_name'],$paths);
                            $this->getMenuTable()->updateMenuTableImage($lastId,$img);
                            
                        }

                    }
                }

                $this->flashmessenger()->addMessage("Datas Added successfully..");
                return $this->redirect()->toRoute('admin/menu');
    		}

            $viewModel = new ViewModel(array(
                'listLanguages' => $this->getLanguages()->listSelectedLanguages(),

            ));
            return $viewModel;
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
            $session = new Container('language');
            $languageId   = $session->offsetGet('languageId');

            $viewModel = new ViewModel(array(
                'listAllMenuData' => $this->getMenuTable()->listAllMenuData($languageId),
                'listAllMenuDatas' => $this->getMenuTable()->listAllMenuDatas(),
                //'listLanguages' => $this->getLanguages()->listLanguages(),
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

    public function deleteAction()
    {
        $config=$this->getServiceLocator()->get('config');
        if ($this->getAuthService()->hasIdentity())
        {
            $delId= $_POST['delid'];
            if($delId !='')
            {
                $menuData = new MenuModel();
                $path=$config['defaultValues']['upload_path'].'/images/products/menu/';

                //Delete Image from folder
                if($deletedRecord= $this->getMenuTable()->datasOfDeletedMenu($delId))
                {
                   
                    foreach ($deletedRecord as $key => $value)
                    {
                        unlink("$path".$value['image']);
                       
                    }
                    
                }
               
                if($this->getMenuTable()->deleteMenuData($delId))
                {        
                    echo "Data deleted SuccessFully...."; exit;
                }
                else
                {
                    echo "You can't Delete...."; exit;
                }
            }
            else
            {
                echo "Contct Your Admin"; exit;
            }
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
            $sliderData = new MenuModel();
            //Status off
            if($_POST['offId'] != '')
            {
                if($this->getMenuTable()->updateMenuStatusOff($_POST['offId']))
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
                if($this->getMenuTable()->updateMenuStatusOn($_POST['onId']))
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
            $id= (int) $this->params()->fromRoute(id);
            $request = $this->getRequest();
                    
            if($request->isPost())
            {
                $menuData = new MenuModel();
                
                $file  = $this->params()->fromFiles('menu_page_image');
                if($file['size'] > 5.243e+6)
                {
                    $this->flashmessenger()->addMessage("You can upload below 5MB file");
                    return $this->redirect()->toRoute('admin/menu/add');
                }
                else
                {
                    $session = new Container('user'); 
                    $userId = $session->offsetGet('userId');
                    $menuData->setId($id);
        			$menuData->setMenuName($request->getPost(menu_title));
        			$menuData->setUserId($userId);
                    $menuData->setLanguage($request->getPost('lan'));
                    $menuData->setUrl($request->getPost(menu_url));
        			$menuData->setUpdatedOn(date('Y-m-d H:i:s'));
                    $this->getMenuTable()->updateAllMenuData($menuData);

                    $path=$config['defaultValues']['upload_path'];
                    if($this->params()->fromFiles('menu_page_image') != '')
                    {
                        $file  = $this->params()->fromFiles('menu_page_image');
                        
                        $isFileUploaded = 1;
                        
                        $ext= explode('.',$file['name']);
                        $img= $id.'.'.$ext[1];
                        
                        if(!empty($file['name']))
                        {         
                            $paths= $path.'/images/products/menu/'.$img;
                            move_uploaded_file($_FILES['menu_page_image']['tmp_name'],$paths);
                            $this->getMenuTable()->updateMenuTableImage($id,$img);
                            
                        }

                    }

                    $this->flashmessenger()->addMessage("Datas Updated successfully..");
            		return $this->redirect()->toRoute('admin/menu');
                }  
            }
             return new ViewModel(array(
                'editMenuData'=>$this->getMenuTable()->editMenuData($id),
                'listLanguages' => $this->getLanguages()->listSelectedLanguages(),
            ));
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }
        
    }


    public function updateMenuOrderAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            $request= $this->getRequest();
            if($request->isPost())
            {
                $id= $request->getPost('id');
                $order= $request->getPost('order');

                $curOrder   = $this->getMenuTable()->getCurrentOrder($id);
                
                
                $this->getMenuTable()->updateDisplayOrder($order, $id);

                $reOrderLists = $this->getMenuTable()->getAllRec($id);
                
                foreach($reOrderLists as $reOrderList)
                { 
                    if($curOrder < $reOrderList['display_order'])
                    {
                        
                        if($this->getMenuTable()->isMultipleOrderExists($curOrder))
                        {
                            if($this->getMenuTable()->isMultipleOrderExists($reOrderList['display_order']) > 1) 
                                $this->getMenuTable()->updateDisplayOrder(($reOrderList['display_order'] + 1), $reOrderList['id']);
                        }
                        else
                        {
                            $this->getMenuTable()->updateDisplayOrder($curOrder, $reOrderList['id']);
                        }

                        $curOrder = $reOrderList['display_order'];
                    }
                    else
                    {
                        if($this->getMenuTable()->isMultipleOrderExists($reOrderList['display_order']) > 1)                             
                            $this->getMenuTable()->updateDisplayOrder(($reOrderList['display_order'] + 1), $reOrderList['id']);                            
                    }
                }      
                 $viewModel = new ViewModel(array());

                $viewModel->setTerminal(true);
                return $viewModel;

            }
        }
        else
        {
            $this->flashmessenger()->addMessage("Please login...");
            return $this->redirect()->toRoute('admin');
        }


    }

}

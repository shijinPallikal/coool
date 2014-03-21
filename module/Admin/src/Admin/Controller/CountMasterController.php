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

 
use Admin\Model\CountMasterModel;
use Admin\Model\CountMasterTable;


class CountMasterController extends AbstractActionController
{

    protected $countMasterTable;

    public function getCountMasterTable()
    {
        if(!$this->countMasterTable)
        {
            $sm= $this->getServiceLocator();
            $this->countMasterTable = $sm->get('Admin\Model\CountMasterTable'); 
        }
        return $this->countMasterTable;
    }



    //Actions
    public function indexAction()
    {        
    	$this->layout('layout/adminDashboardLayout');
    	
    }

    public function addAction()
    {        
        $this->layout('layout/adminDashboardLayout');

        $request=$this->getRequest();
        if($request->isPost())
        {
            $countData = new CountMasterModel();
            //echo $request->getPost('item'); 
            //echo $request->getPost("count"); exit;
            //Current User Id from Session
            $session = new Container('user'); 
            $userId = $session->offsetGet('userId');
            
            $countData->setItem($request->getPost('item'));
            $countData->setCount($request->getPost("count"));
            $countData->setUserId($userId);
            $lastId=$this->getCountMasterTable()->saveCountMasterData($countData);
        }
    }
    
}

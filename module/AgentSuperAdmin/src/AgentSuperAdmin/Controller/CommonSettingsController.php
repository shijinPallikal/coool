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
use Zend\Validator\File\Size;
use Zend\Session\Storage\SessionStorage;
use Zend\Session\SessionManager;

use Admin\Model\LogoTable;
use Admin\Model\LogoModel;


class CommonSettingsController extends AbstractActionController
{

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

    //Actions
    public function indexAction()
    {     
       $this->layout('layout/agentSuperAdminDashboardLayout');
        
    }
    
    

    public function ajaxListAction()
    {
        $viewModel= new ViewModel(array(
            'logoDatas' => $this->getLogoTable()->listAllLogoForAdmin(),
        ));

        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function statusAction()
    {
        //Status off
        if($_POST['offId'] != '')
        {
            if($this->getLogoTable()->updateSuperAdminStatusOff($_POST['offId']))
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

            if($this->getLogoTable()->updateSuperAdminStatusOn($_POST['onId']))
            {     
                echo "Status Edited SuccessFully....";exit;
            }
            else
            {
                echo "You can't Change Status....";exit;
            }
        }
        
    }
    
   
    
}

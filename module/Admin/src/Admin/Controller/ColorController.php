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

 
use Admin\Model\LogoModel;
use Admin\Model\LogoTable;

use Admin\Model\ColorModel;
use Admin\Model\ColorTable;


class ColorController extends AbstractActionController
{

    protected $logoTable;
    protected $authservice;
    protected $colorTable;



    public function getLogoTable()
    {
        if(!$this->logoTable)
        {
            $sm= $this->getServiceLocator();
            $this->logoTable = $sm->get('Admin\Model\LogoTable'); 
        }
        return $this->logoTable;
    }
    public function getColorTable()
    {
        if(!$this->colorTable)
        {
            $sm= $this->getServiceLocator();
            $this->colorTable = $sm->get('Admin\Model\ColorTable'); 
        }
        return $this->colorTable;
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
        if($this->getAuthService()->hasIdentity())
        {
            $this->layout('layout/adminDashboardLayout');
            $viewModel = new ViewModel(array(
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
    
    

    public function ajaxListAction()
    {
        $viewModel= new ViewModel(array(
            'colorsDatas' => $this->getColorTable()->listAllColorData(),
        ));

        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function statusAction()
    {
        //Status off
        if($_POST['offId'] != '')
        {
            if($this->getColorTable()->updateColorOff($_POST['offId']))
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

            if($this->getColorTable()->updateColorOn($_POST['onId']))
            {     
                echo "Status Edited SuccessFully....";exit;
            }
            else
            {
                echo "You can't Change Status....";exit;
            }
        }
        
    }

    //Default Color Status Action
    public function defaultStatusAction()
    {
        //Status off
        if($_POST['offId'] != '')
        {
            if($this->getColorTable()->updateDefaultColorOff($_POST['offId']))
            {     
                echo "Defalult Style Edited SuccessFully....";exit;
            }
            else
            {
                echo "You can't Change Defalult Style....";exit;
            }
        }
        //Status On
        if($_POST['onId'] != '')
        {

            if($this->getColorTable()->updateDefaultColorOn($_POST['onId']))
            {     
                echo "Defalult Style Edited SuccessFully....";exit;
            }
            else
            {
                echo "You can't Change Defalult Style....";exit;
            }
        }
        
    }
    

    //Color Picker Status Action
    public function pickerStatusAction()
    {
        //Status off
        if($_POST['offId'] != '')
        {
            if($this->getColorTable()->updateColorPickerOff($_POST['offId']))
            {     
                echo "Color Picker is off Stage....";exit;
            }
            else
            {
                echo "You can't Change Color Picker Status....";exit;
            }
        }
        //Status On
        if($_POST['onId'] != '')
        {

            if($this->getColorTable()->updateColorPickerOn($_POST['onId']))
            {     
                echo "Color Picker is on Stage....";exit;
            }
            else
            {
                echo "You can't Change Color Picker Status....";exit;
            }
        }
        
    }
   

    
    


    
}

<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Service\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Math\Rand;
 
use Service\Model\ServiceHistoryModel;
use Service\Model\ServiceHistoryTable;
use Service\Model\PhoneModel;
use Service\Model\PhoneTable;
use Service\Model\EmailModel;
use Service\Model\EmailTable;

class IndexController extends AbstractActionController
{
	//error_reporting(E_ERROR | E_WARNING | E_PARSE);
	protected $serviceHistoryTable;
	protected $EmailTable;
	protected $PhoneTable;



	public function getServiceHistoryTable()
    {
    	if(!$this->serviceHistoryTable)
    	{
    		$sm = $this->getServiceLocator();
       		$this->serviceHistoryTable = $sm->get('Service\Model\ServiceHistoryTable');	
    	}
    	return $this->serviceHistoryTable;
    }

    public function getEmailTable()
    {
    	if(!$this->emailTable)
    	{
    		$sm = $this->getServiceLocator();
       		$this->emailTable = $sm->get('Service\Model\EmailTable');	
    	}
    	return $this->emailTable;
    }
    public function getPhoneTable()
    {
    	if(!$this->phoneTable)
    		{
    			$sm = $this->getServiceLocator();
       			$this->phoneTable = $sm->get('Service\Model\PhoneTable');	
    		}
    			return $this->phoneTable;
    }


    //form Action

    public function listAction()
    {
    	$request = $this->getRequest();
    	$arg = array();
		if($request->isPost())
		{
			$arg['searchName']= $request->getPost('search_name');
			$arg['searchProduct']= $request->getPost('search_product');
			$arg['searchAssign']= $request->getPost('search_assign');
			$arg['searchStatus']= $request->getPost('search_status');

		}

    	return new ViewModel(array(
                 'history' => $this->getServiceHistoryTable()->listHistory($arg),
                 'flashMessages' => $this->flashMessenger()->getMessages(),
        ));
        // $this->getServiceHistoryTable()->listHistory();    

    }

   
    public function addAction()
    {
    	$request = $this->getRequest();

		if($request->isPost())
		{
			
			//To get All Array datas
			$postData = $this->getRequest()->getPost()->toArray();
	    	
			//Objects for Models
            $serviceHistory = new ServiceHistoryModel();
            $emailServiceHistory= new EmailModel();
            $phoneServiceHistory= new PhoneModel();

            //Unique Id
            
            $integer = Rand::getInteger(0,1000);
            $uId=$integer.date('Ymd');
            
            $serviceHistory->setUniqueId($uId);
    		$serviceHistory->setFirstName($request->getPost('firstName'));
    		$serviceHistory->setLastName($request->getPost("lastName"));
    		$serviceHistory->setFamilyName($request->getPost("familyName"));
    		$serviceHistory->setProblemType($request->getPost("problemType"));
    		$serviceHistory->setProductType($request->getPost("productType"));
    		$serviceHistory->setComplaint($request->getPost("complaint"));
    		$serviceHistory->setWhenDone($request->getPost("whenDone"));
    		$serviceHistory->setFinishDate($request->getPost("finishDate"));
    		$serviceHistory->setNextCall($request->getPost("nextCall"));
    		$serviceHistory->setAssignTo($request->getPost("assignTo"));
    		$serviceHistory->setCreatedOn(date('Y-m-d H:i:s'));
    		$serviceLastId=$this->getServiceHistoryTable()->saveServiceHistory($serviceHistory);

    		//Insert Multiple Email
    		if(!empty($postData['email'][0]))
    		{
    			//echo "haii";exit;
                foreach($postData['email'] as $keyIndex => $data)
                {
                	$emailServiceHistory->setEid($serviceLastId);
                    $emailServiceHistory->setEmail($data);
                    $emailServiceHistory->setCreatedOn(date('Y-m-d H:i:s'));
                    $this->getEmailTable()->saveEmail($emailServiceHistory);      
                }
            }

            //Insert Multiple Phone
    		if(!empty($postData['phone'][0]))
    		{
                foreach($postData['phone'] as $keyIndex => $data)
                {
                	//print_r($data);
                    if(!$keyIndex)
                    //print_r($serviceLastId);
                    $phoneServiceHistory->setPid($serviceLastId);
                    $phoneServiceHistory->setPhone($data);
                    $phoneServiceHistory->setCreatedOn(date('Y-m-d H:i:s'));
                    $this->getPhoneTable()->savePhone($phoneServiceHistory);      
                }
            }


    		$this->flashmessenger()->addMessage("Datas saved successfully");
    		return $this->redirect()->toRoute('list');	
    	}
    }

    public function detailedListingAction()
    {

    	$id = (int) $this->params()->fromRoute('id');
    	return new ViewModel(array(
    		'detailedListing'=>$this->getServiceHistoryTable()->detailedListing($id),
            'listEmail'=>$this->getEmailTable()->editEmail($id),
            'listPhone'=>$this->getPhoneTable()->editPhone($id),
    	));
    }

    public function editHistoryAction()
    {

        

    	$id = (int) $this->params()->fromRoute('id');
    	$request = $this->getRequest();
    	
    	
    	if($request->isPost())
		{
						
			$postData = $this->getRequest()->getPost()->toArray();
			//Objects for Models
            $serviceHistory = new ServiceHistoryModel();
            $editEmailHistory= new EmailModel();
            $editPhoneHistory= new PhoneModel();
            /*echo $request->getPost('firstName')."<br>";
            echo $request->getPost('lastName')."<br>";
            echo $request->getPost('familyName')."<br>";
            echo $request->getPost('problemType')."<br>";
            echo $request->getPost('complaint')."<br>";
            echo $request->getPost('whenDone')."<br>";
            echo $request->getPost('finishDate')."<br>";
            echo $request->getPost('nextCall')."<br>";
            echo $request->getPost('assignTo')."<br>";
            echo $request->getPost('status')."<br>";*/
            //print_r($postData['phoneId'])."<br>";
            //print_r($postData['email'])."<br>";
            //exit;
            $serviceHistory->setId($id);
    		$serviceHistory->setFirstName($request->getPost('firstName'));
    		$serviceHistory->setLastName($request->getPost("lastName"));
    		$serviceHistory->setFamilyName($request->getPost("familyName"));
    		$serviceHistory->setProblemType($request->getPost("problemType"));
    		$serviceHistory->setProductType($request->getPost("productType"));
    		$serviceHistory->setComplaint($request->getPost("complaint"));
    		$serviceHistory->setWhenDone($request->getPost("whenDone"));
    		$serviceHistory->setFinishDate($request->getPost("finishDate"));
    		$serviceHistory->setNextCall($request->getPost("nextCall"));
    		$serviceHistory->setAssignTo($request->getPost("assignTo"));
    		$serviceHistory->setStatus($request->getPost("status"));
    		$serviceHistory->setCreatedOn(date('Y-m-d H:i:s'));
    		$serviceLastId=$this->getServiceHistoryTable()->updateServiceHistory($serviceHistory);

    		//Edit Multiple Email
    		if(!empty($postData['emailId']))
    		{
    			foreach($postData['email'] as $keyIndex => $data)
                {
                	//print_r($postData['emailId'][$keyIndex]); exit;
                	$editEmailHistory->setId($postData['emailId'][$keyIndex]);
                	$editEmailHistory->setEid($id);
                    $editEmailHistory->setEmail($data);
                    $editEmailHistory->setCreatedOn(date('Y-m-d H:i:s'));
                    $this->getEmailTable()->updateEmail($editEmailHistory);      
                }
            }

            //Edit Multiple Phone
            if(!empty($postData['phoneId']))
    		{
    			foreach($postData['phone'] as $keyIndex => $data)
                {
                	//print_r($postData['emailId'][$keyIndex]); exit;
                	$editPhoneHistory->setId($postData['phoneId'][$keyIndex]);
                	$editPhoneHistory->setPid($id);
                    $editPhoneHistory->setPhone($data);
                    $editPhoneHistory->setCreatedOn(date('Y-m-d H:i:s'));
                    $this->getPhoneTable()->updatePhone($editPhoneHistory);      
                }
            }


            /*//Edit Multiple Email if entry is empty
    		if(!empty($postData['email']))
    		{
    			//print_r($postData['email']); exit;
    			foreach($postData['email'] as $keyIndex => $data)
                {
                	//print_r($postData['emailId'][$keyIndex]); exit;
                	$editEmailHistory->setEid($id);
                    $editEmailHistory->setEmail($data);
                    $editEmailHistory->setCreatedOn(date('Y-m-d H:i:s'));
                    $this->getEmailTable()->saveEmail($editEmailHistory);      
                }
            }

            //Edit Multiple Phone
            if(!empty($postData['phone']))
    		{
    			foreach($postData['phone'] as $keyIndex => $data)
                {
                    print_r($data); exit;
                	$editPhoneHistory->setPid($id);
                    $editPhoneHistory->setPhone($data);
                    $editPhoneHistory->setCreatedOn(date('Y-m-d H:i:s'));
                    $this->getPhoneTable()->savephone($editPhoneHistory);      
                }
            }*/
            $this->flashMessenger()->addMessage("Data Edited Successfully...");
            return $this->redirect()->toRoute('list');  

		}

        return new ViewModel(array(
    		'editHistory'=>$this->getServiceHistoryTable()->detailedListing($id),
    		'editEmail'=>$this->getEmailTable()->editEmail($id),
    		'editPhone'=>$this->getPhoneTable()->editPhone($id),
    	));


    }

    public function statusChangeAction()
    {
    	$id = (int) $this->params()->fromRoute('id');
    	$status = (int) $this->params()->fromRoute('status');
    	return new ViewModel(array(
    		'statuschange'=>$this->getServiceHistoryTable()->statusChange($id,$s),
    	));
    	
    }

}
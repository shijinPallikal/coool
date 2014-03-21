<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class LoginModel implements InputFilterAwareInterface
{
	public $id;
	public $username;
	public $password;
	public $status;
	public $ipAddress;
	public $lastLogin;
	public $status;
	public $createdOn;
	public $updatedOn;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setUsername($username)
	{
		$this->username = $username;				
	}
	
	public function setPassword($password)
	{
		$this->password = $password;				
	}
	public function setStatus($status)
	{
		$this->status= $status;
	}
	public function setIpAddress($ipAddress)
	{
		$this->ipAddress= $ipAddress;
	}
	public function setCreatedOn($createdOn)
	{
		//echo $createdOn;
		$this->createdOn= $createdOn;
	}
	public function setLastLogin($lastLogin)
	{
		//echo $createdOn;
		$this->lastLogin= $lastLogin;
	}
	public function setUpdatedOn($updatedOn)
	{
		$this->updatedOn= $updatedOn;
	}

	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class UserEmailModel implements InputFilterAwareInterface
{
	public $id;
	public $uid;
	public $email;
	public $status;
	public $createdOn;
	public $updatedOn;
	
	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setUserId($uid)
	{
		$this->uid = $uid;				
	}
	public function setEmail($email)
	{
		$this->email = $email;				
	}

	public function setCreatedOn($createdOn)
	{
		$this->createdOn = $createdOn;				
	}

	public function setUpdatedOn($updatedOn)
	{
		$this->updatedOn = $updatedOn;				
	}
	
	public function setStatus($status)
	{
		$this->status= $status;
	}
	
	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
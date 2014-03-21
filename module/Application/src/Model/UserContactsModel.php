<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class UserContactsModel implements InputFilterAwareInterface
{
	public $id;
	public $companyName;
	public $contactPerson;
	public $phone;
	public $email;
	public $interest;
	public $list;
		
	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setCompanyName($companyName)
	{
		$this->companyName = $companyName;				
	}
	public function setContactPerson($contactPerson)
	{
		$this->contactPerson = $contactPerson;				
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;				
	}
	public function setEmail($email)
	{
		$this->email = $email;				
	}
	public function setInterest($interest)
	{
		$this->interest = $interest;				
	}

	public function setList($list)
	{
		$this->list = $list;				
	}

	// Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}

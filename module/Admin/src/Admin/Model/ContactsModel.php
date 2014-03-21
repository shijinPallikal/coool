<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ContactsModel implements InputFilterAwareInterface
{
	public $id;
	public $uid;
	public $countryId;
	public $title;
	public $phone;
	public $serviceEmail;
	public $infoEmail;
	public $description;
	public $status;
	
	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setUserId($uid)
	{
		$this->uid = $uid;				
	}
	public function setCountryId($countryId)
	{
		$this->countryId = $countryId;				
	}

	public function setTitle($title)
	{
		$this->title = $title;				
	}
	public function setDescription($description)
	{
		$this->description = $description;				
	}
	public function setPhone($phone)
	{
		$this->phone = $phone;				
	}

	public function setServiceEmail($serviceEmail)
	{
		$this->serviceEmail = $serviceEmail;				
	}

	public function setInfoEmail($infoEmail)
	{
		$this->infoEmail = $infoEmail;				
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
<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CountryModel implements InputFilterAwareInterface
{
	public $id;
	public $uid;
	public $country;
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
	public function setCountry($country)
	{
		$this->country = $country;				
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
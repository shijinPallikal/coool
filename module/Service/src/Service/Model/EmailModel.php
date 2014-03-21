<?php
namespace Service\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class EmailModel implements InputFilterAwareInterface
{
	public $id;
	public $email;
	public $eid;
	public $createdOn;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setEmail($email)
	{
		//print_r($email);
		$this->email= $email;
	}
	public function setEid($eid)
	{	
		//print_r($eid);
		$this->eid= $eid;
	}
	public function setCreatedOn($createdOn)
	{
		$this->createdOn= $createdOn;
	}

	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){

   }

}
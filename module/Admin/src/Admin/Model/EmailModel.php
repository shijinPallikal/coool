<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class EmailModel implements InputFilterAwareInterface
{
	public $id;
	public $type;
	public $email;
	public $email1;
	public $eid;
	public $createdOn;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}

	public function setType($type)
	{
		$this->type = $type;				
	}

	public function setEmail($email)
	{
		//print_r($email);
		$this->email= $email;
	}

	public function setEmail1($email1)
	{
		//print_r($email);
		$this->email1= $email1;
	}

	public function setEid($eid)
	{	
		//print_r($eid);
		$this->eid= $eid;
	}
	
	// Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){

   }

}
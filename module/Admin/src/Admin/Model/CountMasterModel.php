<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CountMasterModel implements InputFilterAwareInterface
{
	public $id;
	public $uid;
	public $item;
	public $count;
	
	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setUserId($uid)
	{
		$this->uid = $uid;				
	}
	public function setItem($item)
	{
		$this->item = $item;				
	}
	public function setCount($count)
	{
		$this->count= $count;
	}
	
	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
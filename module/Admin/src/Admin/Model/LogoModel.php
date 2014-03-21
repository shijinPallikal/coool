<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class LogoModel implements InputFilterAwareInterface
{
	public $id;
	public $uid;
	public $image;
	public $showTitle;
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
	public function setImage($image)
	{
		$this->image = $image;				
	}
	public function setStatus($status)
	{
		$this->status = $status;				
	}
	public function setShowTitle($showTitle)
	{
		$this->showTitle= $showTitle;
	}
	
	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
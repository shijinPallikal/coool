<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class SliderColorModel implements InputFilterAwareInterface
{
	public $id;
	public $bgColor;
	public $discriptionColor;
	public $status;
	public $pattern;
	public $patternStatus;
	public $opacity;
	
	
	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setBgColor($bgColor)
	{
		$this->bgColor = $bgColor;				
	}
	public function setDiscriptionColor($discriptionColor)
	{
		$this->discriptionColor = $discriptionColor;				
	}
	public function setStatus($status)
	{
		$this->status = $status;				
	}
	public function setPattern($pattern)
	{
		$this->pattern = $pattern;				
	}
	public function setPatternStatus($patternStatus)
	{
		$this->patternStatus = $patternStatus;				
	}
	public function setOpacity($opacity)
	{
		$this->opacity = $opacity;				
	}
	
		
	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
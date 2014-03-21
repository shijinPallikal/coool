<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ColorModel implements InputFilterAwareInterface
{
	public $id;
	public $color;
	public $colorField;
	public $colorStatus;
	public $colorPicker;

	
	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setColor($color)
	{
		$this->color = $color;				
	}
	public function setColorField($colorField)
	{
		$this->colorField = $colorField;				
	}
	public function setColorStatus($colorStatus)
	{
		$this->colorStatus = $colorStatus;				
	}
	public function setColorPicker($colorPicker)
	{
		$this->colorPicker = $colorPicker;				
	}
		
	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class LanguagesModel implements InputFilterAwareInterface
{
	public $id;
	public $languages;
	public $status;
	
	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setLanguages($languages)
	{
		$this->languages = $languages;				
	}
	public function setStatus($status)
	{
		$this->status = $status;				
	}
			
	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
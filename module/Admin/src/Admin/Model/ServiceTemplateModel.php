<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ServiceTemplateModel implements InputFilterAwareInterface
{
	public $id;
	public $template_name;
	public $service_template;		
        public $status;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setTemplateName($template_name)
	{
		$this->template_name = $template_name;				
	}
	public function setServiceTemplate($service_template)
	{
		$this->service_template = $service_template;				
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
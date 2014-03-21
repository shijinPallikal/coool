<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ServicePagesModel implements InputFilterAwareInterface
{
	public $id;
	public $page_name;
	public $page_template;	
        public $service_menu_no;
        public $status;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setPageName($page_name)
	{
		$this->page_name = $page_name;				
	}
	public function setPageTemplate($page_template)
	{
		$this->page_template = $page_template;				
	}
        public function setServiceMenuNo($service_menu_no)
	{
		$this->service_menu_no = $service_menu_no;				
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
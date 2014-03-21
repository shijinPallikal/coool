<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ServicePageContentModel implements InputFilterAwareInterface
{
	public $id;
	public $page_id;
	public $content_title;	
        public $content_description;
        public $content_image;
        public $status;
        public $sub_id;

        protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setPageId($page_id)
	{
		$this->page_id = $page_id;				
	}
	public function setContentTitle($content_title)
	{
		$this->content_title = $content_title;				
	}
        public function setContentDescription($content_description)
	{
		$this->content_description = $content_description;				
	}
        public function setContentImage($content_image)
	{
		$this->content_image = $content_image;				
	}
        public function setStatus($status)
	{
		$this->status = $status;				
	}   
        public function setSubId($sub_id)
	{
		$this->sub_id = $sub_id;				
	} 
	

	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
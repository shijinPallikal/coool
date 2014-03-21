<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class OtherServicesModel implements InputFilterAwareInterface
{
	public $id;
	public $service_title;
        public $service_link;
        public $service_description;
	public $service_price;
        public $service_image;
	public $isTitle;
        public $status;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}

	public function setServiceTitle($service_title)
	{
		$this->service_title= $service_title;
	}
        
        public function setServiceLink($service_link)
        {
            $this->service_link= $service_link;
        }

        public function setServiceDescription($service_description)
	{
		//print_r($phone);
		$this->service_description= $service_description;
	}
	public function setServicePrice($service_price)
	{
		//print_r($pid);
		$this->service_price= $service_price;
	}
	public function setServiceImage($service_image)
	{
		$this->service_image= $service_image;
	}
        public function setIsTitle($isTitle)
	{
		$this->isTitle= $isTitle;
	}
        public function setStatus($status)
	{
		$this->status= $status;
	}

	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){

   }

}
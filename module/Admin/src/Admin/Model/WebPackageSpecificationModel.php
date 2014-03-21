<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class WebPackageSpecificationModel implements InputFilterAwareInterface
{
	public $id;
	public $pkg_specification;
	public $package_one;
	public $package_two;
	public $package_three;	
        public $status;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setPkgSpecification($pkg_specification)
	{
		$this->pkg_specification = $pkg_specification;				
	}
	public function setPackageOne($package_one)
	{
		$this->package_one = $package_one;				
	}
	public function setPackageTwo($package_two)
	{
		$this->package_two = $package_two;				
	}
	public function setPackageThree($package_three)
	{
		$this->package_three = $package_three;				
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
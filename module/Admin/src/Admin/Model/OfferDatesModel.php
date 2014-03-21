<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class OfferDatesModel implements InputFilterAwareInterface
{
	public $id;
	public $package;
	public $packageId;
	public $offerDate;
	
	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setPackage($package)
	{
		$this->package = $package;				
	}
	public function setPackageId($packageId)
	{
		$this->packageId = $packageId;				
	}
	public function setOfferDate($offerDate)
	{
		$this->offerDate= $offerDate;
	}
	

	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
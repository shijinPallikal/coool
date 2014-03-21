<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class SmallPackageModel implements InputFilterAwareInterface
{
	public $id;
	public $uid;
	public $user;
	public $productTitle;
	public $description;
	public $image1;
	public $image2;
	public $area;
	public $status;
	public $productOrder;
	public $url;
	public $offerDate;
	public $defaults;
	public $createdOn;
	public $updatedOn;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setUser($user)
	{
		$this->user = $user;				
	}
	public function setUserId($uid)
	{
		$this->uid = $uid;				
	}
	public function setProductTitle($productTitle)
	{
		$this->productTitle = $productTitle;				
	}
	public function setDescription($description)
	{
		$this->description = $description;				
	}
	public function setImage1($image1)
	{
		$this->image1 = $image1;				
	}
	public function setImage2($image2)
	{
		$this->image2 = $image2;				
	}
	public function setArea($area)
	{
		$this->area = $area;				
	}
	public function setStatus($status)
	{
		$this->status= $status;
	}
	public function setProductOrder($productOrder)
	{
		$this->productOrder= $productOrder;
	}
	public function setUrl($url)
	{
		$this->url= $url;
	}
	public function setOfferDate($offerDate)
	{
		$this->offerDate= $offerDate;
	}
	public function setDefault($defaults)
	{
		//echo $defaults; exit;
		$this->defaults= $defaults;
	}
	public function setCreatedOn($createdOn)
	{
		$this->createdOn= $createdOn;
	}
	public function setUpdatedOn($updatedOn)
	{
		$this->updatedOn= $updatedOn;
	}

	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
   }

}
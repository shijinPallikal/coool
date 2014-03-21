<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class EcommercePackageModel implements InputFilterAwareInterface
{
	public $id;
	public $uid;
	public $title;
	public $language;
	public $description;
	public $image;
	public $status;
	public $order;
	public $url;
	public $createdOn;
	public $updatedOn;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setLanguage($language)
	{
		$this->language = $language;				
	}
	public function setUserId($uid)
	{
		$this->uid = $uid;				
	}
	public function setTitle($title)
	{
		$this->title = $title;				
	}
	public function setDescription($description)
	{
		$this->description = $description;				
	}
	public function setImage($image)
	{
		$this->image = $image;				
	}
	public function setStatus($status)
	{
		$this->status= $status;
	}
	public function setOrder($order)
	{
		$this->order= $order;
	}
	public function setUrl($url)
	{
		$this->url= $url;
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
<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PagesModel implements InputFilterAwareInterface
{
	public $id;
	public $title;
	public $user;
	public $description;
	public $subTitle;
	public $createdOn;
	public $url;
	public $status;
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
	public function setTitle($title)
	{
		$this->title = $title;				
	}
	public function setDescription($description)
	{
		$this->description = $description;				
	}
	public function setSubTitle($subTitle)
	{
		$this->subTitle = $subTitle;				
	}
	public function setUrl($url)
	{
		$this->url= $url;
	}
	public function setStatus($status)
	{
		$this->status= $status;
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
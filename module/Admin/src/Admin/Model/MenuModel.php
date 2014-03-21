<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class MenuModel implements InputFilterAwareInterface
{
	public $id;
	public $uid;
	public $language;
	public $adminPage;
	public $menuName;
	public $image;
	public $url;
	public $status;
	public $controller;
	public $order;
	public $createdOn;
	public $updatedOn;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setUserId($uid)
	{
		$this->uid = $uid;				
	}
	public function setAdminPage($adminPage)
	{
		$this->adminPage = $adminPage;
	}
	public function setLanguage($language)
	{
		$this->language = $language;				
	}
	public function setMenuName($menuName)
	{
		$this->menuName = $menuName;				
	}
	public function setStatus($status)
	{
		$this->status= $status;
	}
	public function setController($controller)
	{
		$this->controller= $controller;
	}
	public function setImage($image)
	{
		$this->image= $image;
	}
	public function setUrl($url)
	{
		$this->url= $url;
	}
	public function setOrder($order)
	{
		$this->order= $order;
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
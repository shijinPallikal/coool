<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class WebPackageModel implements InputFilterAwareInterface
{
	public $id;
	public $title;
	public $description;
        
        public $setupfee;
        public $monthlycost;
        public $marketprice;
        public $specification;

        public $package_one_name;
        public $package_one_link;
        public $package_one_image;
	public $package_one_setupfee_kr;
	public $package_one_monthlycost_kr;
	public $package_one_marketplace_kr;
        
        public $package_two_name;
        public $package_two_link;
        public $package_two_image;
	public $package_two_setupfee_kr;
	public $package_two_monthlycost_kr;
	public $package_two_marketplace_kr;
        
        public $package_three_name;
        public $package_three_link;
        public $package_three_image;        
	public $package_three_setupfee_kr;
	public $package_three_monthlycost_kr;
	public $package_three_marketplace_kr;
   
	public $package_one_setupfee_euro;
	public $package_one_monthlycost_euro;
	public $package_one_marketplace_euro;

	public $package_two_setupfee_euro;
	public $package_two_monthlycost_euro;
	public $package_two_marketplace_euro;
  
	public $package_three_setupfee_euro;
	public $package_three_monthlycost_euro;
	public $package_three_marketplace_euro;
	

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}	
	public function setTitle($title)
	{
		$this->title = $title;				
	}
	public function setDescription($description)
	{
		$this->description = $description;				
	}
        
        
        public function setSetupfee($setupfee)
	{
		$this->setupfee = $setupfee;				
	}
        public function setMonthlycost($monthlycost)
	{
		$this->monthlycost = $monthlycost;				
	}
        public function setMarketprice($marketprice)
	{
		$this->marketprice = $marketprice;				
	}
        public function setSpecification($specification)
	{
		$this->specification = $specification;				
	}
        
        
	public function setPackageOneName($package_one_name)
	{
		$this->package_one_name = $package_one_name;				
	}
        public function setPackageOneLink($package_one_link)
        {
            $this->package_one_link=$package_one_link;
        }
        public function setPackageOneImage($package_one_image)
	{
		$this->package_one_image = $package_one_image;				
	}
	public function setPackageOneSetupfeeKr($package_one_setupfee_kr)
	{
		$this->package_one_setupfee_kr = $package_one_setupfee_kr;				
	}
	public function setPackageOneMonthlycostKr($package_one_monthlycost_kr)
	{
		$this->package_one_monthlycost_kr = $package_one_monthlycost_kr;				
	}
	public function setPackageOneMarketplaceKr($package_one_marketplace_kr)
	{
		$this->package_one_marketplace_kr= $package_one_marketplace_kr;
	}
        
        
        public function setPackageTwoName($package_two_name)
	{
		$this->package_two_name = $package_two_name;				
	}
        public function setPackageTwoLink($package_two_link)
        {
            $this->package_two_link=$package_two_link;
        }
        public function setPackageTwoImage($package_two_image)
	{
		$this->package_two_image = $package_two_image;				
	}
	public function setPackageTwoSetupfeeKr($package_two_setupfee_kr)
	{
		$this->package_two_setupfee_kr = $package_two_setupfee_kr;				
	}
	public function setPackageTwoMonthlycostKr($package_two_monthlycost_kr)
	{
		$this->package_two_monthlycost_kr = $package_two_monthlycost_kr;				
	}
	public function setPackageTwoMarketplaceKr($package_two_marketplace_kr)
	{
		$this->package_two_marketplace_kr= $package_two_marketplace_kr;
	}
        
        
        public function setPackageThreeName($package_three_name)
	{
		$this->package_three_name = $package_three_name;				
	}
        public function setPackageThreeLink($package_three_link)
        {
            $this->package_three_link=$package_three_link;
        }
        public function setPackageThreeImage($package_three_image)
	{
		$this->package_three_image = $package_three_image;				
	}
	public function setPackageThreeSetupfeeKr($package_three_setupfee_kr)
	{
		$this->package_three_setupfee_kr = $package_three_setupfee_kr;				
	}
	public function setPackageThreeMonthlycostKr($package_three_monthlycost_kr)
	{
		$this->package_three_monthlycost_kr = $package_three_monthlycost_kr;				
	}
	public function setPackageThreeMarketplaceKr($package_three_marketplace_kr)
	{
		$this->package_three_marketplace_kr= $package_three_marketplace_kr;
	}
      
	
	public function setPackageOneSetupfeeEuro($package_one_setupfee_euro)
	{
		$this->package_one_setupfee_euro = $package_one_setupfee_euro;				
	}
	public function setPackageOneMonthlycostEuro($package_one_monthlycost_euro)
	{
		$this->package_one_monthlycost_euro = $package_one_monthlycost_euro;				
	}
	public function setPackageOneMarketplaceEuro($package_one_marketplace_euro)
	{
		$this->package_one_marketplace_euro= $package_one_marketplace_euro;
	}
       
        
	public function setPackageTwoSetupfeeEuro($package_two_setupfee_euro)
	{
		$this->package_two_setupfee_euro = $package_two_setupfee_euro;				
	}
	public function setPackageTwoMonthlycostEuro($package_two_monthlycost_euro)
	{
		$this->package_two_monthlycost_euro = $package_two_monthlycost_euro;				
	}
	public function setPackageTwoMarketplaceEuro($package_two_marketplace_euro)
	{
		$this->package_two_marketplace_euro= $package_two_marketplace_euro;
	}
       
        
	public function setPackageThreeSetupfeeEuro($package_three_setupfee_euro)
	{
		$this->package_three_setupfee_euro = $package_three_setupfee_euro;				
	}
	public function setPackageThreeMonthlycostEuro($package_three_monthlycost_euro)
	{
		$this->package_three_monthlycost_euro = $package_three_monthlycost_euro;				
	}
	public function setPackageThreeMarketplaceEuro($package_three_marketplace_euro)
	{
		$this->package_three_marketplace_euro= $package_three_marketplace_euro;
	}
      

	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){     
    }

}
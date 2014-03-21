<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;   
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Validator\File\Size;
use Zend\Session\Storage\SessionStorage;
use Zend\Session\SessionManager; 

use Admin\Model\WebPackageModel;
use Admin\Model\WebPackageTable;

use Admin\Model\WebPackageSpecificationModel;
use Admin\Model\WebPackageSpecificationTable;

class WebsiteController extends AbstractActionController
{
    protected $webPackageTable;
    protected $webPackageSpecificationTable;
    
    public function getWebPackageTable()
    {
        if(!$this->webPackageTable)
        {
            $sm= $this->getServiceLocator();
            $this->webPackageTable = $sm->get('Admin\Model\WebPackageTable'); 
        }
        return $this->webPackageTable;
    }
    
    public function getWebPackageSpecificationTable()
    {
        if(!$this->webPackageSpecificationTable)
        {
            $sm= $this->getServiceLocator();
            $this->webPackageSpecificationTable = $sm->get('Admin\Model\WebPackageSpecificationTable'); 
        }
        return $this->webPackageSpecificationTable;
    }
    //Actions
    public function indexAction()
    {     
        $this->layout('layout/adminDashboardLayout');
        return new ViewModel(array(
                'webpackages'   =>$this->getWebPackageTable()->listAllWebPackage(),
                'specifications' =>$this->getWebPackageSpecificationTable()->listAllWebPackageSpecification(),
                ));
    }
    
    public function addPackageAction()
    {
        $this->layout('layout/adminDashboardLayout');
        $request=$this->getRequest();     
	$upload = $this->UploadFilesLib();
        $config=$this->getServiceLocator()->get('config');
        if($request->isPost())
        {
            //exit('ok');
            $setupFeeOne    = $request->getPost("setupfee");
            $monthlyCostOne = $request->getPost("monthcost");
            $marketPlaceOne = $request->getPost("marketplace");
            
            $setupFeeTwo      = $request->getPost("setupfee_two");
            $monthlyCostTwo   = $request->getPost("monthcost_two");
            $marketPlaceTwo   = $request->getPost("marketplace_two");
            
            $setupFeeThree      = $request->getPost("setupfee_three");
            $monthlyCostThree   = $request->getPost("monthcost_three");
            $marketPlaceThree   = $request->getPost("marketplace_three");
             $path=$config['defaultValues']['upload_path'];
            if(isset($_FILES['field']['name'][0]) && !empty($_FILES['field']['name'][0])){
                        $file= $_FILES['field']['name'];                                                    
                        $firstImg = $upload->getRandFileNa($file);                             
                        $upload->copyFile('field',$path.'/images/products/web_package', 1, $firstImg);
            }
            if(isset($_FILES['field2']['name'][0]) && !empty($_FILES['field2']['name'][0])){
                        $file1= $_FILES['field2']['name'];                                                    
                        $secondImg = $upload->getRandFileNa($file1);                             
                        $upload->copyFile('field2',$path.'/images/products/web_package', 1, $secondImg);
            }
            if(isset($_FILES['field3']['name'][0]) && !empty($_FILES['field3']['name'][0])){
                        $file3= $_FILES['field3']['name'];                                                    
                        $thirdImg = $upload->getRandFileNa($file3);                             
                        $upload->copyFile('field3',$path.'/images/products/web_package', 1, $thirdImg);
            }
            
            $webPackageData = new WebPackageModel();
            //Current User Id from Session
            $session = new Container('user'); 
            $userId = $session->offsetGet('userId');            
                        
            $webPackageData->setTitle($request->getPost('form_title'));
            $webPackageData->setDescription($request->getPost("form_description"));
            
            $webPackageData->setPackageOneName($request->getPost("package_name_one"));
            $webPackageData->setPackageOneImage($firstImg); 
            
            $webPackageData->setPackageOneSetupfeeKr($setupFeeOne[0]);
            $webPackageData->setPackageOneMonthlycostKr($monthlyCostOne[0]);
            $webPackageData->setPackageOneMarketplaceKr($marketPlaceOne[0]);
            
            $webPackageData->setPackageTwoName($request->getPost("package_name_two"));
            $webPackageData->setPackageTwoImage($secondImg);
            
            $webPackageData->setPackageTwoSetupfeeKr($setupFeeTwo[0]);
            $webPackageData->setPackageTwoMonthlycostKr($monthlyCostTwo[0]);
            $webPackageData->setPackageTwoMarketplaceKr($marketPlaceTwo[0]);
            
            $webPackageData->setPackageThreeName($request->getPost("package_name_three"));
            $webPackageData->setPackageThreeImage($thirdImg); 
            
            $webPackageData->setPackageThreeSetupfeeKr($setupFeeThree[0]);
            $webPackageData->setPackageThreeMonthlycostKr($monthlyCostThree[0]);
            $webPackageData->setPackageThreeMarketplaceKr($marketPlaceThree[0]);            
              
            $webPackageData->setPackageOneSetupfeeEuro($setupFeeOne[1]);
            $webPackageData->setPackageOneMonthlycostEuro($monthlyCostOne[1]);
            $webPackageData->setPackageOneMarketplaceEuro($marketPlaceOne[1]);
                       
            $webPackageData->setPackageTwoSetupfeeEuro($setupFeeTwo[1]);
            $webPackageData->setPackageTwoMonthlycostEuro($monthlyCostTwo[1]);
            $webPackageData->setPackageTwoMarketplaceEuro($marketPlaceTwo[1]);
                       
            $webPackageData->setPackageThreeSetupfeeEuro($setupFeeThree[1]);
            $webPackageData->setPackageThreeMonthlycostEuro($monthlyCostThree[1]);
            $webPackageData->setPackageThreeMarketplaceEuro($marketPlaceThree[1]);
           
            $lastId = $this->getWebPackageTable()->saveWebPackageData($webPackageData);            
          

        }

        return new ViewModel(array(
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));
        
        

    }

    public function editAjaxAction()
    {
        $request=$this->getRequest();
//        $upload = $this->UploadFilesLib();
//         $path='/var/www/coolwebsite/public';
//         
//          if(isset($_FILES['pakOneImg']['name'][0]) && !empty($_FILES['pakOneImg']['name'][0])){
//                        $file= $_FILES['pakOneImg']['name'];                                                    
//                        $firstImg = $upload->getRandFileNa($file);                             
//                        $upload->copyFile('field',$path.'/images/products/web_package', 1, $firstImg);
//              }
          
        $webPackageDataUpdate = new WebPackageModel();
        $webPackageDataUpdate->setId($request->getPost('id'));
        if($request->getPost('pageHead')!='undefined'){
            $webPackageDataUpdate->setTitle($request->getPost('pageHead'));
        }
        if($request->getPost('pageDesc')!='undefined'){
            $webPackageDataUpdate->setDescription($request->getPost('pageDesc'));
        }
        
        
        if($request->getPost('setupfee')!='undefined'){
            $webPackageDataUpdate->setSetupfee($request->getPost('setupfee'));
        }
        if($request->getPost('monthlycost')!='undefined'){
            $webPackageDataUpdate->setMonthlycost($request->getPost('monthlycost'));
        }
        if($request->getPost('marketprice')!='undefined'){
            $webPackageDataUpdate->setMarketprice($request->getPost('marketprice'));
        }
        if($request->getPost('specihead')!='undefined'){
            $webPackageDataUpdate->setSpecification($request->getPost('specihead'));
        }
        
        
        if($request->getPost('packageFirst')!='undefined'){
            $webPackageDataUpdate->setPackageOneName($request->getPost('packageFirst'));
        }
        if($request->getPost('packageSecond')!='undefined'){
            $webPackageDataUpdate->setPackageTwoName($request->getPost('packageSecond'));
        }
        if($request->getPost('packageThird')!='undefined'){
            $webPackageDataUpdate->setPackageThreeName($request->getPost('packageThird'));
        }
        
        
        if($request->getPost('pkgOneLink')!='undefined'){
            $webPackageDataUpdate->setPackageOneLink($request->getPost('pkgOneLink'));           
        }
        if($request->getPost('pkgTwoLink')!='undefined'){
            $webPackageDataUpdate->setPackageTwoLink($request->getPost('pkgTwoLink'));
        }
        if($request->getPost('pkgThreeLink')!='undefined'){
            $webPackageDataUpdate->setPackageThreeLink($request->getPost('pkgThreeLink'));
        }
        
        
        if($request->getPost('firstFeeKr')!='undefined'){
            $webPackageDataUpdate->setPackageOneSetupfeeKr($request->getPost('firstFeeKr'));
        }
        if($request->getPost('firstFeeKr')!='undefined'){
        $webPackageDataUpdate->setPackageOneSetupfeeEuro($request->getPost('firstFeeEuro'));
        }
        if($request->getPost('secondFeeKr')!='undefined'){
        $webPackageDataUpdate->setPackageTwoSetupfeeKr($request->getPost('secondFeeKr'));
        }
        if($request->getPost('secondFeeEuro')!='undefined'){
        $webPackageDataUpdate->setPackageTwoSetupfeeEuro($request->getPost('secondFeeEuro'));
        }
        if($request->getPost('secondFeeEuro')!='undefined'){
        $webPackageDataUpdate->setPackageThreeSetupfeeKr($request->getPost('thirdFeeKr'));
        }
        if($request->getPost('thirdFeeEuro')!='undefined'){
        $webPackageDataUpdate->setPackageThreeSetupfeeEuro($request->getPost('thirdFeeEuro'));
        }
        
        if($request->getPost('firstCostKr')!='undefined'){
        $webPackageDataUpdate->setPackageOneMonthlycostKr($request->getPost('firstCostKr'));
        }
        if($request->getPost('firstCostEuro')!='undefined'){
        $webPackageDataUpdate->setPackageOneMonthlycostEuro($request->getPost('firstCostEuro'));
        }
        if($request->getPost('secondCostKr')!='undefined'){
        $webPackageDataUpdate->setPackageTwoMonthlycostKr($request->getPost('secondCostKr'));
        }
        if($request->getPost('secondCostEuro')!='undefined'){
        $webPackageDataUpdate->setPackageTwoMonthlycostEuro($request->getPost('secondCostEuro'));
        }
        if($request->getPost('thirdCostKr')!='undefined'){
        $webPackageDataUpdate->setPackageThreeMonthlycostKr($request->getPost('thirdCostKr'));
        }
        if($request->getPost('thirdCostEuro')!='undefined'){
        $webPackageDataUpdate->setPackageThreeMonthlycostEuro($request->getPost('thirdCostEuro'));
        }
        
        if($request->getPost('firstMarketKr')!='undefined'){        
        $webPackageDataUpdate->setPackageOneMarketplaceKr($request->getPost('firstMarketKr'));
        }
        if($request->getPost('firstMarketEuro')!='undefined'){
        $webPackageDataUpdate->setPackageOneMarketplaceEuro($request->getPost('firstMarketEuro'));
        }
        if($request->getPost('secondMarketKr')!='undefined'){
        $webPackageDataUpdate->setPackageTwoMarketplaceKr($request->getPost('secondMarketKr'));
        }
        if($request->getPost('secondMarketEuro')!='undefined'){
        $webPackageDataUpdate->setPackageTwoMarketplaceEuro($request->getPost('secondMarketEuro'));
        }
        if($request->getPost('thirdMarketKr')!='undefined'){
        $webPackageDataUpdate->setPackageThreeMarketplaceKr($request->getPost('thirdMarketKr'));
        }
        if($request->getPost('thirdMarketEuro')!='undefined'){
        $webPackageDataUpdate->setPackageThreeMarketplaceEuro($request->getPost('thirdMarketEuro'));
        }
        
        
        $this->getWebPackageTable()->updateWebPackageData($webPackageDataUpdate);
        //echo $request->getPost('id');     
        exit;
    }
    
    public function editImageAction(){
        $this->layout('layout/adminDashboardLayout');
        $config=$this->getServiceLocator()->get('config');
        $request=$this->getRequest();     
	$upload = $this->UploadFilesLib();
        $path=$config['defaultValues']['upload_path'];
//        if($request->isPost())
//        {    
            $webPackageImgUpdate = new WebPackageModel(); 
            $webPackageImgUpdate->setId($request->getPost('packageId'));
            if(isset($_FILES['fileimg1']['name'][0]) && !empty($_FILES['fileimg1']['name'][0])){
                        $file= $_FILES['fileimg1']['name'];                                                    
                        $firstImg = $upload->getRandFileNa($file);                             
                        $upload->copyFile('fileimg1',$path.'/images/products/web_package', 1, $firstImg);
                        $webPackageImgUpdate->setPackageOneImage($firstImg);
                        echo $firstImg;
            }     
            if(isset($_FILES['fileimg2']['name'][0]) && !empty($_FILES['fileimg2']['name'][0])){
                        $file1= $_FILES['fileimg2']['name'];                                                    
                        $secondImg = $upload->getRandFileNa($file1);                             
                        $upload->copyFile('fileimg2',$path.'/images/products/web_package', 1, $secondImg);
                        $webPackageImgUpdate->setPackageTwoImage($secondImg);
                        echo $secondImg;
            } 
            if(isset($_FILES['fileimg3']['name'][0]) && !empty($_FILES['fileimg3']['name'][0])){
                        $file2= $_FILES['fileimg3']['name'];                                                    
                        $thirdImg = $upload->getRandFileNa($file2);                             
                        $upload->copyFile('fileimg3',$path.'/images/products/web_package', 1, $thirdImg);
                        $webPackageImgUpdate->setPackageThreeImage($thirdImg);
                        echo $thirdImg;
            }
            $this->getWebPackageTable()->updateWebPackageData($webPackageImgUpdate);
          
//        }
       
        exit;
        
    }

    public function deleteAction()
    {
        $delId= $_POST['delid'];
       
        if($delId !='')
        {
            $ecommercePackageData = new EcommercePackageModel();

            
            if($this->getEcommercePackageTable()->deleteWebPackageData($delId))
            {        
                echo "Data deleted SuccessFully....";exit;
            }
            else
            {
                echo "You can't Delete....";exit;
            }
        }
        else
        {
            echo "Contct Your Admin";exit;
        }

    }
    
}
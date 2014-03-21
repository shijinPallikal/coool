<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class WebPackageTable extends AbstractTableGateway
{
    protected $table = 'web_packages';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }



    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->id))
            $return['id'] = $obj->id;

        if(isset($obj->title))
            $return['title'] = $obj->title;

        if(isset($obj->description))
            $return['description'] = $obj->description;
         
        
        if(isset($obj->setupfee))
            $return['setupfee'] = $obj->setupfee;
        
        if(isset($obj->monthlycost))
            $return['monthlycost'] = $obj->monthlycost;
         
        if(isset($obj->marketprice))
            $return['marketprice'] = $obj->marketprice;
         
        if(isset($obj->specification))
            $return['specification'] = $obj->specification;
        
        
        if(isset($obj->package_one_name))
            $return['package_one_name'] = $obj->package_one_name;
        
        if(isset($obj->package_one_link))
            $return['package_one_link'] = $obj->package_one_link;
        
        if(isset($obj->package_one_image))
            $return['package_one_image'] = $obj->package_one_image;

        if(isset($obj->package_one_setupfee_kr))
            $return['package_one_setupfee_kr'] = $obj->package_one_setupfee_kr;

        if(isset($obj->package_one_monthlycost_kr))
            $return['package_one_monthlycost_kr'] = $obj->package_one_monthlycost_kr;

        if(isset($obj->package_one_marketplace_kr))
            $return['package_one_marketplace_kr'] = $obj->package_one_marketplace_kr;
        
        
        if(isset($obj->package_two_name))
            $return['package_two_name'] = $obj->package_two_name;
        
        if(isset($obj->package_two_link))
            $return['package_two_link'] = $obj->package_two_link;
        
        if(isset($obj->package_two_image))
            $return['package_two_image'] = $obj->package_two_image;

        if(isset($obj->package_two_setupfee_kr))
            $return['package_two_setupfee_kr'] = $obj->package_two_setupfee_kr;

        if(isset($obj->package_two_monthlycost_kr))
            $return['package_two_monthlycost_kr'] = $obj->package_two_monthlycost_kr;

        if(isset($obj->package_two_marketplace_kr))
            $return['package_two_marketplace_kr'] = $obj->package_two_marketplace_kr;
        
        
        if(isset($obj->package_three_name))
            $return['package_three_name'] = $obj->package_three_name;
        
        if(isset($obj->package_three_link))
            $return['package_three_link'] = $obj->package_three_link;
        
        if(isset($obj->package_three_image))
            $return['package_three_image'] = $obj->package_three_image;

        if(isset($obj->package_three_setupfee_kr))
            $return['package_three_setupfee_kr'] = $obj->package_three_setupfee_kr;

        if(isset($obj->package_three_monthlycost_kr))
            $return['package_three_monthlycost_kr'] = $obj->package_three_monthlycost_kr;

        if(isset($obj->package_three_marketplace_kr))
            $return['package_three_marketplace_kr'] = $obj->package_three_marketplace_kr;

        
    
        if(isset($obj->package_one_setupfee_euro))
            $return['package_one_setupfee_euro'] = $obj->package_one_setupfee_euro;

        if(isset($obj->package_one_monthlycost_euro))
            $return['package_one_monthlycost_euro'] = $obj->package_one_monthlycost_euro;

        if(isset($obj->package_one_marketplace_euro))
            $return['package_one_marketplace_euro'] = $obj->package_one_marketplace_euro;
        
       
        if(isset($obj->package_two_setupfee_euro))
            $return['package_two_setupfee_euro'] = $obj->package_two_setupfee_euro;

        if(isset($obj->package_two_monthlycost_euro))
            $return['package_two_monthlycost_euro'] = $obj->package_two_monthlycost_euro;

        if(isset($obj->package_two_marketplace_euro))
            $return['package_two_marketplace_euro'] = $obj->package_two_marketplace_euro;
        
      
        if(isset($obj->package_three_setupfee_euro))
            $return['package_three_setupfee_euro'] = $obj->package_three_setupfee_euro;

        if(isset($obj->package_three_monthlycost_euro))
            $return['package_three_monthlycost_euro'] = $obj->package_three_monthlycost_euro;

        if(isset($obj->package_three_marketplace_euro))
            $return['package_three_marketplace_euro'] = $obj->package_three_marketplace_euro;
        
       

        return $return;
    }
	 
    public function saveWebPackageData(WebPackageModel $obj)
    {  
        //print_r($obj); exit;
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }
  
    public function listAllWebPackage()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->order('id DESC');
        });
        return $resultSet;
    }

    public function deleteWebPackageData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }

   public function updateWebPackageData(WebPackageModel $obj)
    {   //print_r($obj);
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        //print_r($obj->id);
        //print_r($obj->package_one_image);
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        //print_r($statement);
        $statement->execute();
    }
    
    
    
    
}
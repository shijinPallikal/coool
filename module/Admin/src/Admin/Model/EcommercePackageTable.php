<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class EcommercePackageTable extends AbstractTableGateway
{
    protected $table = 'ecommerce_package';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }



    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->userId))
            $return['uid'] = $obj->userId;

        if(isset($obj->language))
            $return['language_id'] = $obj->language;

        if(isset($obj->title))
            $return['title'] = $obj->title;

        if(isset($obj->description))
            $return['description'] = $obj->description;

        if(isset($obj->image))
            $return['image'] = $obj->image;

        if(isset($obj->status))
            $return['status'] = $obj->status;

        if(isset($obj->order))
            $return['display_order'] = $obj->order;

        if(isset($obj->url))
            $return['url'] = $obj->url;

        if(isset($obj->createdOn))
            $return['created_on'] = $obj->createdOn;

        if(isset($obj->updatedOn))
            $return['updated_on'] = $obj->updatedOn;

        return $return;
    }
	 
    public function saveEcommercePackageData(EcommercePackageModel $obj)
    {  
        //print_r($obj);exit;
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }
   public function updateEcommercePackageImage($id,$img)
    {  
        $sql = "update `ecommerce_package` set image='$img' where id= $id";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }  
    
    
    public function listAllEcommercePackage($languageId)
    {  
        $sql = "select * from ecommerce_package where language_id= '$languageId' order by id desc";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function updateEcommercePackageStatusOff($id)
    {  
        $sql = "update `ecommerce_package` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
    public function updateEcommercePackageStatusOn($id)
    {  
        $sql = "update `ecommerce_package` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function deleteEcommercePackageData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }

   public function listEcommercePackageData($id)
    {  
        $sql = "SELECT * FROM `ecommerce_package` where id='$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }
   
    public function editEcommercePackageData(EcommercePackageModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));

        $statement = $sql->prepareStatementForSqlObject($update);
        //print_r($statement);exit;
        $statement->execute();
    }

    public function listAllPackages()
    {
        $sql = "SELECT * FROM ecommerce_packag where status='$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }

    public function getCurrentOrder($id)
    {
        $sql = "SELECT display_order FROM ecommerce_package WHERE id = $id";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute(); 
        $row = $result->current();
        if($row) return $row['display_order']; else return -1;
    }

    public function updateDisplayOrder($order, $id)
    { 
        $sql = "UPDATE ecommerce_package SET display_order = $order WHERE id = $id";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute(); 
    }
    public function getAllRec($id)
    {
        $sql = "SELECT id, display_order FROM ecommerce_package WHERE id != $id ORDER BY display_order";
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        return $result; 
    }
    public function isMultipleOrderExists($order)
    {
        $sql = "SELECT count(display_order) AS display_order FROM ecommerce_package WHERE display_order = $order";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute(); 
        $row = $result->current();
        if($row) return $row['display_order']; else return 0;
    }
    public function listEcommercePackages($languageId)
    {
        $sql = "SELECT * FROM ecommerce_package WHERE status=1 and language_id= '$languageId' ORDER BY display_order ASC LIMIT 8";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute();
        return $result;
    }     
}
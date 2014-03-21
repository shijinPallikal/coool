<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class MenuTable extends AbstractTableGateway
{
    protected $table = 'menu';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->menuName))
            $return['menu_name'] = $obj->menuName;

        if(isset($obj->uid))
            $return['uid'] = $obj->uid;

        if(isset($obj->language))
            $return['language_id'] = $obj->language;

        if(isset($obj->status))
            $return['status'] = $obj->status;

        if(isset($obj->controller))
            $return['controller'] = $obj->controller;

        if(isset($obj->image))
            $return['image'] = $obj->image;

        if(isset($obj->url))
            $return['url'] = $obj->url;

        if(isset($obj->order))
        $return['display_order'] = $obj->order;

        if(isset($obj->createdOn))
            $return['createdOn'] = $obj->createdOn;

        if(isset($obj->updatedOn))
            $return['updatedOn'] = $obj->updatedOn;

        return $return;
    }
	
    public function saveMenuDatas(MenuModel $obj)
    {   
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);        
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }    

    public function listAllMenuData($languageId)
    {  
        $sql = "SELECT me.id as meid,la.id as laid,me.* FROM menu AS me INNER JOIN languages AS la ON me.language_id = la.id where me.language_id= '$languageId' ORDER BY me.language_id DESC";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }
    public function listAllMenuDatas()
    {  
        $sql = "SELECT * from menu";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    } 

    public function deleteMenuData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }
    
    public function updateMenuStatusOn($id)
    {  
        $sql = "update `menu` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }   


    public function updateMenuStatusOff($id)
    {  
        $sql = "update `menu` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function editMenuData($id)
    {  
        $sql = "SELECT * FROM `menu` where id='$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }    

    public function updateAllMenuData(MenuModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }

    public function getCurrentOrder($id)
    {
        $sql = "SELECT display_order FROM menu WHERE id = $id";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute(); 
        $row = $result->current();
        if($row) return $row['display_order']; else return -1;
    }
    public function updateDisplayOrder($order, $id)
    { 
        $sql = "UPDATE menu SET display_order = $order WHERE id = $id";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute(); 
    }
    public function getAllRec($id)
    {
        $sql = "SELECT id, display_order FROM menu WHERE id != $id ORDER BY display_order";
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        return $result; 
    }

    public function isMultipleOrderExists($order)
    {
        $sql = "SELECT count(display_order) AS display_order FROM menu WHERE display_order = $order";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute(); 
        $row = $result->current();
        if($row) return $row['display_order']; else return 0;
    }

    public function updateMenuTableImage($lastId,$img)
    {
        $sql = "UPDATE menu SET image = '$img' WHERE id = $lastId";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute(); 
    }

    public function menuMaxId()
    {
        $sql = "SELECT * FROM menu WHERE display_order = (SELECT MAX( display_order ) FROM menu )";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute();
        $row = $result->current();
        if($row) return $row['display_order']; else return 0; 
    }

    public function datasOfDeletedMenu($delId)
    {
        $sql = "SELECT * FROM menu WHERE id = $delId";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute();
        return $result; 
    }

    public function listMenuDatas($languageId)
    {
        $sql = "SELECT * FROM menu WHERE status=1 and language_id='$languageId' ORDER BY display_order ASC LIMIT 6";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute();
        return $result;
    }

    public function listMenuDatasImage($languageId)
    {
        $sql = "SELECT * FROM menu WHERE status=1 and controller='ecommerce' and language_id='$languageId'";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute();
        return $result;
    }
    
    public function listMenuDatasImageContacts($languageId)
    {
        $sql = "SELECT * FROM menu WHERE status=1 and controller='contactus' and language_id='$languageId'";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute();
        return $result;
    }
    public function listMenuDatasImageProducts($languageId)
    {
        $sql = "SELECT * FROM menu WHERE status=1 and controller='ourproducts' and language_id='$languageId'";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute();
        return $result;
    }
    public function listMenuDatasImageWeb($languageId)
    {
      
        $sql = "SELECT * FROM menu WHERE status=1 and controller='websitepackages' and language_id='$languageId'";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute();
        return $result;
    }
    public function listMenuDatasImageservices($languageId)
    {
      
        $sql = "SELECT * FROM menu WHERE status=1 and controller='services' and language_id='$languageId'";
        $statement = $this->adapter->query($sql);         
        $result    = $statement->execute();
        return $result;
    }
     
     

       
}
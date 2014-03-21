<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ServicePageContentTable extends AbstractTableGateway
{
    protected $table = 'service_page_contents';
   	
  	public function __construct(Adapter $adapter)
        {
            $this->adapter = $adapter;
        }

      public function exchangeToArray($obj)
      {
        $return = array();
     
        if(isset($obj->id))
            $return['id'] = $obj->id;

        if(isset($obj->page_id))
            $return['page_id'] = $obj->page_id;

        if(isset($obj->content_title))
            $return['content_title'] = $obj->content_title;
        
        if(isset($obj->content_description))
            $return['content_description'] = $obj->content_description;
        
        if(isset($obj->content_image))
            $return['content_image'] = $obj->content_image;
        
        if(isset($obj->status))
            $return['status'] = $obj->status;
        
        if(isset($obj->sub_id))
            $return['sub_id'] = $obj->sub_id;
        
        return $return;
      }
	 
    public function saveServicePageContentData(ServicePageContentModel $obj)
    {  
        
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();  
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }
    
    public function updateServicePageContentData(ServicePageContentModel $obj)
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
    
    public function deleteServicePageContentData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }
    
    public function listAllServicePageContent()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->order('id DESC');
        });
        return $resultSet;
    }
    
    public function pageContentDataSingle($cntId)
    {  
        $sql = "SELECT * FROM `service_page_contents` where id='$cntId'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }
    
    public function pageContentData($pageid)
    {  
        $sql = "SELECT * FROM `service_page_contents` where page_id='$pageid'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }
}
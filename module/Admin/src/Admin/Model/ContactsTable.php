<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ContactsTable extends AbstractTableGateway
{
    protected $table = 'contact_detail';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->uid))
        $return['user_id'] = $obj->uid;

        if(isset($obj->countryId))
        $return['country_id'] = $obj->countryId;

        if(isset($obj->title))
        $return['title'] = $obj->title;

        if(isset($obj->phone))
        $return['phone'] = $obj->phone;

        if(isset($obj->serviceEmail))
        $return['service_email'] = $obj->serviceEmail;

        if(isset($obj->infoEmail))
        $return['info_email'] = $obj->infoEmail;

        if(isset($obj->description))
        $return['description'] = $obj->description;


        if(isset($obj->status))
            $return['status'] = $obj->status;


        return $return;
    }


    public function saveContactsData(ContactsModel $obj)
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

    public function listAllData()
    {
        $sql= "SELECT c.id,c.country,co.id,co.* FROM contact_detail AS co LEFT JOIN country AS c ON co.country_id= c.id";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function listAllContactsData()
    {
        $sql= "SELECT c.id,co.title,co.description,co.phone,co.service_email,co.info_email,c.country,co.id FROM contact_detail AS co LEFT JOIN country AS c ON co.country_id= c.id WHERE co.status=1";
        //echo $sql; exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function editContactData($id)
    {
        $sql= "SELECT c.id,c.country,co.id,co.* FROM contact_detail AS co LEFT JOIN country AS c ON co.country_id= c.id WHERE co.id= '$id'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;  
    }

    public function updateContactsData(ContactsModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    } 

    public function updateContactsStatusOn($id)
    {  
        $sql = "update `contact_detail` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }   


    public function updateContactsStatusOff($id)
    {  
        $sql = "update `contact_detail` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    /*public function listAllCountryData()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->order('id DESC');
        });
        return $resultSet;
    }
    

    public function deleteCountryData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    } 
	 
    public function editCountryData($id)
    {  
        $sql = "SELECT * FROM `country` where id='$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    } 

     */ 
   
}
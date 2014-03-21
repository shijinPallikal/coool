<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class CountryTable extends AbstractTableGateway
{
    protected $table = 'country';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->uid))
        $return['uid'] = $obj->uid;

        if(isset($obj->country))
        $return['country'] = $obj->country;


        if(isset($obj->status))
            $return['status'] = $obj->status;


        return $return;
    }

    public function getAllCountry()
    {
        $sql = "select *  from country  where status= 1 order by id DESC"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;

    }

    public function saveCountryData(CountryModel $obj)
    {  
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }

    
    public function listAllCountryData()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->order('id DESC');
        });
        return $resultSet;
    }
    public function updateCountryStatusOn($id)
    {  
        $sql = "update `country` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }   


    public function updateCountryStatusOff($id)
    {  
        $sql = "update `country` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
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

    public function updateCountryData(CountryModel $obj)
    {  
        //print_r($obj);
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }   
   
}
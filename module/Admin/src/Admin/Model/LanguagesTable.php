<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class LanguagesTable extends AbstractTableGateway
{
    protected $table = 'languages';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->languages))
          $return['languages'] = $obj->languages;

        if(isset($obj->status))
          $return['status'] = $obj->status;

        return $return;
    }

    public function saveLanguageData(LanguagesModel $obj)
    {   
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);        
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }
    public function listLanguagesDatas()
    {  
        $sql = "select * from languages"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function updateLanguagesOff($id)
    {
        $sql = "update languages set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function updateLanguagesOn($id)
    {
        $sql = "update languages set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function editLanguagesData($id)
    {
        $sql = "select * from languages where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function updateLanguageData(LanguagesModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }
    public function listLanguages()
    {
        $sql = "select languages from languages"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function listSelectedLanguages()
    {
        $sql = "select * from languages"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function listLanguagesSessionDatas()
    {
        $sql = "select * from languages where status= 1 limit 1"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
}
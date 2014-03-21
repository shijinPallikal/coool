<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class UserEmailTable extends AbstractTableGateway
{
    protected $table = 'user_email';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->uid))
            $return['user_id'] = $obj->uid;

        if(isset($obj->email))
            $return['email'] = $obj->email;

        if(isset($obj->status))
            $return['status'] = $obj->status;

        if(isset($obj->createdOn))
            $return['created_on'] = $obj->createdOn;

         if(isset($obj->updatedOn))
            $return['updated_on'] = $obj->updatedOn;

        return $return;
    }


    public function saveUserEmailData(UserEmailModel $obj)
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
        $sql= "SELECT * FROM user_email";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function editUserEmailData($id)
    {
        $sql= "SELECT * FROM user_email WHERE id= '$id'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;  
    }

    public function updateUserEmailData(UserEmailModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    } 

    public function updateUserEmailStatusOn($id)
    {  
        $sql = "update `user_email` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }   


    public function updateUserEmailStatusOff($id)
    {  
        $sql = "update `user_email` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function ListAllUserEmail()
    {
        $sql= "SELECT * FROM user_email WHERE status= '1' ORDER BY created_on DESC LIMIT 1";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;  
    }

    public function ListUserEmail()
    {
        $sql= "SELECT * FROM user_email WHERE status= '1'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;  
    }

    public function updateEmailData(UserEmailModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }
 
   
}
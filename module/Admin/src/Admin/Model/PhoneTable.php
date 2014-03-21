<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class PhoneTable extends AbstractTableGateway
{
    protected $table = 'phone';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();
        if(isset($obj->id))
            $return['id'] = $obj->id;

        if(isset($obj->category))
            $return['category'] = $obj->category;

        if(isset($obj->phone))
            $return['phone'] = $obj->phone;

        if(isset($obj->pid))
            $return['pid'] = $obj->pid;

        if(isset($obj->createdOn))
            $return['createdOn'] = $obj->createdOn;

        return $return;
    }
	 
    public function savePhone(PhoneModel $obj)
    {
        $sql = new Sql($this->adapter);		    
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);	       
        $result = $statement->execute();                    
        return $result;
    }

    public function editPhone($id) {
        $sql = "SELECT * FROM `phone` where pid=$id"; 
        //$sql = "SELECT * FROM serviceHistory inner join email on email.eid=serviceHistory.id inner join phone on phone.pid=serviceHistory.id where serviceHistory.id=$id"; 
        //echo $sql;exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function updatePhone(PhoneModel $obj)
    {
        //print_r($obj->id); exit;
        $sql= new Sql($this->adapter);
        $update=$sql->update($this->table);
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id'=> $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $result= $statement->execute();
        return $result;
    }
}
<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class EmailTable extends AbstractTableGateway
{
    protected $table = 'email';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();
        if(isset($obj->id))
            $return['id'] = $obj->id;

        if(isset($obj->type))
            $return['type'] = $obj->type;

        if(isset($obj->email))
            $return['email'] = $obj->email;

        if(isset($obj->email1))
            $return['email1'] = $obj->email1;

        if(isset($obj->eid))
            $return['eid'] = $obj->eid;

        return $return;
    }
	 
    public function saveEmail(EmailModel $obj)
    {
        $sql = new Sql($this->adapter);		    
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);	       
        $result = $statement->execute();                    
        return $result;
    }

    public function saveEmail1(EmailModel $obj)
    {
        $sql = new Sql($this->adapter);         
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        return $result;
    }

    /*public function editEmail($id)
    {
        $sql = "SELECT * FROM `email` where eid=$id"; 
        //$sql = "SELECT * FROM serviceHistory inner join email on email.eid=serviceHistory.id inner join phone on phone.pid=serviceHistory.id where serviceHistory.id=$id"; 
        //echo $sql;exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function updateEmail(EmailModel $obj)
    {
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();                    
        return $result;

    }*/
}
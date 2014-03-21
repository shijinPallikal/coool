<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class LoginTable extends AbstractTableGateway
{
    protected $table = 'login';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->username))
        $return['username'] = $obj->username;

        if(isset($obj->password))
        $return['password'] = $obj->password;


        if(isset($obj->status))
            $return['status'] = $obj->status;

        if(isset($obj->createdOn))
            $return['createdOn'] = $obj->createdOn;

        if(isset($obj->updatedOn))
            $return['updatedOn'] = $obj->updatedOn;

        return $return;
    }
	 
    public function getUserDetails($username, $password)
    {  
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table);   
        $select->where(array('username' => $username, 'password' => md5($password)));      
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result;
    }

    public function updateUserLogin($userid,$ip)
    {
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set (array('last_login' => date("Y-m-d H:i:s"),'ip_address' => $ip));
        $update->where(array('id' => $userid));
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();
        return $result;  
    }         
}
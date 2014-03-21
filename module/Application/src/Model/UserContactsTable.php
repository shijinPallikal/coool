<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class UserContactsTable extends AbstractTableGateway
{
    protected $table = 'user_contacts';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->companyName))
            $return['comp_name'] = $obj->companyName;

        if(isset($obj->contactPerson))
        $return['cont_person'] = $obj->contactPerson;

        if(isset($obj->phone))
            $return['cont_phone'] = $obj->phone;

        if(isset($obj->email))
            $return['cont_email'] = $obj->email;

        if(isset($obj->interest))
        $return['interested_in'] = $obj->interest;


        if(isset($obj->list))
            $return['list'] = $obj->list;


        return $return;
    }


    public function saveUserContactsData(UserContactsModel $obj)
    {  
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
   
}

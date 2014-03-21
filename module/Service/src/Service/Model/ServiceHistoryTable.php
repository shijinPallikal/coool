<?php
namespace Service\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ServiceHistoryTable extends AbstractTableGateway
{
    protected $table = 'serviceHistory';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->uniqueId))
        $return['uniqueId'] = $obj->uniqueId;

        if(isset($obj->firstName))
        $return['firstName'] = $obj->firstName;

        if(isset($obj->lastName))
        $return['lastName'] = $obj->lastName;


        if(isset($obj->familyName))
            $return['familyName'] = $obj->familyName;

        if(isset($obj->problemType))
            $return['problemType'] = $obj->problemType;


        if(isset($obj->productType))
            $return['productType'] = $obj->productType;


        if(isset($obj->complaint))
            $return['complaint'] = $obj->complaint;


        if(isset($obj->whenDone))
            $return['whenDone'] = $obj->whenDone;


        if(isset($obj->finishDate))
            $return['finishDate'] = $obj->finishDate;


        if(isset($obj->nextCall))
            $return['nextCall'] = $obj->nextCall;

        if(isset($obj->assignTo))
            $return['assignTo'] = $obj->assignTo;

        if(isset($obj->status))
            $return['status'] = $obj->status;

        if(isset($obj->createdOn))
            $return['createdOn'] = $obj->createdOn;

        if(isset($obj->updatedOn))
            $return['updatedOn'] = $obj->updatedOn;

        return $return;
    }
	 
    public function saveServiceHistory(ServiceHistoryModel $obj)
    {
        $sql = new Sql($this->adapter);		    
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);	       
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }

    public function listHistory($arg) 
    {
        $count=count($arg);

        if($count == '')
        {
            $sql = "SELECT * FROM `serviceHistory` order by Id desc"; 
        }
        else
        {
            $name= $arg['searchName'];
            $product= $arg['searchProduct'];
            $assign= $arg['searchAssign'];
            $status= $arg['searchStatus'];
            
            $sql = "SELECT * FROM `serviceHistory` WHERE firstName LIKE '$name' OR lastName LIKE '$name' OR productType LIKE '$product' OR assignTo LIKE '$assign' OR status LIKE '$status'";
        }
        
        
        //echo $sql;exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function detailedListing($id) {
        $sql = "SELECT * FROM `serviceHistory` where Id=$id"; 
        //$sql = "SELECT * FROM serviceHistory inner join email on email.eid=serviceHistory.id inner join phone on phone.pid=serviceHistory.id where serviceHistory.id=$id"; 
        //echo $sql;exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function statusChange($id,$s) {
        $sql = "update `serviceHistory` set status=$s where Id=$id"; 
        //$sql = "SELECT * FROM serviceHistory inner join email on email.eid=serviceHistory.id inner join phone on phone.pid=serviceHistory.id where serviceHistory.id=$id"; 
        //echo $sql;exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function updateServiceHistory(ServiceHistoryModel $obj)
    {
        //print_r($obj); exit;
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        //print_r($statement);exit;
        $statement->execute();   
    }
}
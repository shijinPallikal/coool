<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class OtherServicesTable extends AbstractTableGateway
{
    protected $table = 'other_services';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();
        if(isset($obj->id))
            $return['id'] = $obj->id;

        if(isset($obj->service_title))
            $return['service_title'] = $obj->service_title;
       
        if(isset($obj->service_link))
            $return['service_link'] = $obj->service_link;

        if(isset($obj->service_description))
            $return['service_description'] = $obj->service_description;

        if(isset($obj->service_price))
            $return['service_price'] = $obj->service_price;

        if(isset($obj->service_image))
            $return['service_image'] = $obj->service_image;
        
        if(isset($obj->isTitle))
            $return['isTitle'] = $obj->isTitle;
        
        if(isset($obj->status))
            $return['status'] = $obj->status;

        return $return;
    }
	 
    public function saveOtherServices(OtherServicesModel $obj)
    {
       // print_r($obj);exit;
        $sql = new Sql($this->adapter);		    
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);	       
        $result = $statement->execute();                    
        return $result;
    }
    
    public function listAllOtherServices()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->where('isTitle=0');
            $select->order('id desc');
            
        });
        return $resultSet;
    }  
    
    public function listOtherServicesTitle()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->where('isTitle=1');
            $select->order('id asc');
            
        });
        return $resultSet;
    }

    public function deleteOtherServices($delId)
    {        
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }

    public function singleOtherServicesrow($id) {
        $sql = "SELECT * FROM `other_services` where id=$id"; 
        //$sql = "SELECT * FROM serviceHistory inner join email on email.eid=serviceHistory.id inner join phone on phone.pid=serviceHistory.id where serviceHistory.id=$id"; 
        //echo $sql;exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function updateOtherServices(OtherServicesModel $obj)
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
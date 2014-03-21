<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class WebPackageSpecificationTable extends AbstractTableGateway
{
    protected $table = 'web_package_specification';
   	
      public function __construct(Adapter $adapter)
      {
          $this->adapter = $adapter;
      }

      public function exchangeToArray($obj)
      {
        $return = array();
     
        if(isset($obj->id))
            $return['id'] = $obj->id;

        if(isset($obj->pkg_specification))
            $return['pkg_specification'] = $obj->pkg_specification;

        if(isset($obj->package_one))
            $return['package_one'] = $obj->package_one;
        

        if(isset($obj->package_two))
            $return['package_two'] = $obj->package_two;
        
        if(isset($obj->package_three))
            $return['package_three'] = $obj->package_three;
        
        if(isset($obj->status))
            $return['status'] = $obj->status;
        
        
        return $return;
      }
	 
    public function saveWebPackageSpecificationData(WebPackageSpecificationModel $obj)
    {  
        $valArr = $this->exchangeToArray($obj);
        if(empty($valArr)){ return FALSE; }
        
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($valArr);
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $statement->execute(); 
        //$result = $statement->execute();        
        //$lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        //return $lastId;
    }
        
    public function listAllWebPackageSpecification()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->order('id DESC');
        });
        return $resultSet;
    }

    public function listWebPackageSpecificationData($id)
    {  
        $sql = "SELECT * FROM `big_package` where id='$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }

    public function updateWebPackageSpecificationStatusOff($id)
    {  
        $sql = "update `big_package` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
    public function updateWebPackageSpecificationStatusOn($id)
    {  
        $sql = "update `big_package` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function deleteWebPackageSpecificationData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }

   public function updateWebPackageSpecificationData(WebPackageSpecificationModel $obj)
    {  
       //print_r($obj);
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        //print_r($obj->id);
        //print_r($obj->package_one_image);
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        //print_r($statement);exit;
        $statement->execute();
    }   

    public function listWebPackagesSpecification($todayDate)
    {
        $sql = "SELECT * FROM big_package AS bp INNER JOIN offer_dates AS od ON bp.id=od.package_id WHERE od.offer_date = '$todayDate' AND bp.status= '1' AND od.package= 'big' ORDER BY bp.created_on DESC LIMIT 1 ";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;
    }   

    public function listWebPackagesSpecification1()
    {
        $sql = "SELECT * FROM big_package AS bp INNER JOIN offer_dates AS od ON bp.id=od.package_id WHERE bp.status= '1' AND od.package= 'big' ORDER BY bp.created_on DESC LIMIT 1 ";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;
    }   

   
    
}
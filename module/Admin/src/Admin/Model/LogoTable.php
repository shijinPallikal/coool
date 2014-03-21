<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class LogoTable extends AbstractTableGateway
{
    protected $table = 'logo';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->uid))
        $return['uid'] = $obj->uid;

        if(isset($obj->image))
        $return['image'] = $image->image;


        if(isset($obj->showTitle))
          $return['show_title'] = $obj->showTitle;

        if(isset($obj->status))
          $return['status'] = $obj->status;


        return $return;
    }

    public function saveLogoData(LogoModel $obj)
    {  
        //print_r($obj); exit;
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }

    public function updateLogoTable($lastId,$img)
    {
        $sql = "update `logo` set image='$img' where id= $lastId"; 
        //echo $sql;exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
    public function listAllLogo()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->order('id DESC');
        });
        return $resultSet;
    }

    public function editLogoData($id)
    {
        $sql = "select * from `logo` where id= '$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
      
    public function updateLogoData(LogoModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }   

    public function listLogo()
    {
        $sql = "SELECT * FROM logo LIMIT 1"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function listAllLogoForAdmin() 
    {
        $sql = "SELECT * FROM logo LIMIT 1";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute();
        return $result;
    } 

    public function updateSuperAdminStatusOff($id)
    {
        $sql = "update logo set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function updateSuperAdminStatusOn($id)
    {
        $sql = "update logo set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

   
   
}
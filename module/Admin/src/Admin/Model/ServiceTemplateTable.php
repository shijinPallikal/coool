<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ServiceTemplateTable extends AbstractTableGateway
{
    protected $table = 'service_templates';
   	
  	public function __construct(Adapter $adapter)
  	{
            $this->adapter = $adapter;
        }

      public function exchangeToArray($obj)
      {
        $return = array();
     
        if(isset($obj->id))
            $return['id'] = $obj->id;

        if(isset($obj->template_name))
            $return['template_name'] = $obj->template_name;

        if(isset($obj->service_template))
            $return['service_template'] = $obj->service_template;
        
        if(isset($obj->status))
            $return['status'] = $obj->status;

        
        return $return;
      }
      
    public function saveServicePageTemplateData(ServiceTemplateModel $obj)
    {  
       // print_r($obj); exit;
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }  
   public function updateServicePageTemplateData(ServiceTemplateModel $obj)
    {   //print_r($obj);
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));        
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        //print_r($statement);
        $statement->execute();
    }
    
    public function deleteServicePageTemplateData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }
    public function listAllServiceTemplates()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->order('id DESC');
        });
        return $resultSet;
    }

    public function serviceTemplateDataSingle($id)
    {  
        $sql = "SELECT * FROM `service_templates` where id='$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }

       
}
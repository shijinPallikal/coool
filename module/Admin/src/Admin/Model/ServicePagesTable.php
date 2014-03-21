<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ServicePagesTable extends AbstractTableGateway
{
    protected $table = 'service_pages';
   	
    public function __construct(Adapter $adapter)
    {
      $this->adapter = $adapter;
    }

    public function exchangeToArray($obj)
    {
      $return = array();

      if(isset($obj->id))
          $return['id'] = $obj->id;

      if(isset($obj->page_name))
          $return['page_name'] = $obj->page_name;

      if(isset($obj->page_template))
          $return['page_template'] = $obj->page_template;
      
        if(isset($obj->service_menu_no))
          $return['service_menu_no'] = $obj->service_menu_no;

      if(isset($obj->status))
          $return['status'] = $obj->status;

      
      return $return;
    }
    
    public function saveServicePageData(ServicePagesModel $obj)
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
    public function updateServicePageData(ServicePagesModel $obj)
    {   //print_r($obj);
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        //print_r($obj->id);
        //print_r($obj->package_one_image);
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        //print_r($statement);
        $statement->execute();
    }
    public function deleteServicePageData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }
    public function listAllServicePages($serId=null)
    {   
        $resultSet = $this->select(function (Select $select) use($serId)
        {     
            $select->where(array('service_menu_no' => $serId));
            $select->order('id DESC');
        });
        return $resultSet;
    }
    
    public function ServicePagesDataSingle($id)
    {  
        $sql = "SELECT * FROM `service_pages` where id='$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }
    
    public function ServicePageWithTemplate($serId=null)
    {  
        $sql = "SELECT s.id, s.page_name, s.page_template,s.service_menu_no,s.status,t.template_name, t.service_template FROM service_pages AS s LEFT JOIN service_templates AS t ON s.page_template = t.id where s.service_menu_no=$serId "; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }
    
    public function ServicePageWithTemplateSingle($pageId)
    {  
        $sql = "SELECT s.id, s.page_name, s.page_template, s.status,t.template_name, t.service_template FROM service_pages AS s LEFT JOIN service_templates AS t ON s.page_template = t.id where s.id=$pageId"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }
    
    
    
       
}
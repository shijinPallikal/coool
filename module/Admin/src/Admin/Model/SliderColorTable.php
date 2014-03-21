<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class SliderColorTable extends AbstractTableGateway
{
    protected $table = 'slider_color';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->bgColor))
          $return['bg_color'] = $obj->bgColor;

        if(isset($obj->discriptionColor))
          $return['discription_color'] = $obj->discriptionColor;

        if(isset($obj->status))
          $return['status'] = $obj->status;

        if(isset($obj->pattern))
          $return['pattern'] = $obj->pattern;

         if(isset($obj->patternStatus))
          $return['pattern_status'] = $obj->patternStatus;

        if(isset($obj->opacity))
          $return['opacity'] = $obj->opacity;

      
        return $return;
    }

    public function saveSliderColorData(SliderColorModel $obj)
    {
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }

    public function listAllSliderColorData() 
    {
        $sql = "SELECT * FROM slider_color";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute();
        return $result;
    }
    public function listSliderColorData() 
    {
        $sql = "SELECT * FROM slider_color where status='1'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute();
        return $result;
    }
    public function editSliderColorData()
    {
        $sql = "select * from slider_color"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function updateAllSliderColorData(SliderColorModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }

    public function updateSliderPatternStatusOn($id)
    {  
        $sql = "update `slider_color` set pattern_status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }   


    public function updateSliderPatternStatusOff($id)
    {  
        $sql = "update `slider_color` set pattern_status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function updateSliderColorStatusOn($id)
    {  
        $sql = "update `slider_color` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }   


    public function updateSliderColorStatusOff($id)
    {  
        $sql = "update `slider_color` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
   
   
}
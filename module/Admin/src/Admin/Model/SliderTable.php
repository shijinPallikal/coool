<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class SliderTable extends AbstractTableGateway
{
    protected $table = 'home_slider';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }



    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->userId))
        $return['userId'] = $obj->userId;

        if(isset($obj->image))
        $return['image'] = $obj->image;

         if(isset($obj->title))
        $return['title'] = $obj->title;

         if(isset($obj->description))
        $return['description'] = $obj->description;

         if(isset($obj->url))
        $return['url'] = $obj->url;

        if(isset($obj->status))
            $return['status'] = $obj->status;


         if(isset($obj->order))
        $return['order'] = $obj->order;


        if(isset($obj->createdOn))
            $return['createdOn'] = $obj->createdOn;

        if(isset($obj->updatedOn))
            $return['updatedOn'] = $obj->updatedOn;

        return $return;
    }
	 
    public function saveSliderData(SliderModel $obj)
    {  
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }
    
    public function listAllSliderData()
    {  
        $resultSet = $this->select(function (Select $select)
        {
            $select->order('id DESC');
        });
        return $resultSet;
    }

    public function deleteSliderData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }

        
    public function updateSliderStatusOn($id)
    {  
        $sql = "update `home_slider` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }   


    public function updateSliderStatusOff($id)
    {  
        $sql = "update `home_slider` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function updateSliderImage($lastId,$img)
    {  
        
        $sql = "update `home_slider` set image='$img' where id= '$lastId'"; 
        //echo $sql;exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }    

    public function updateSliderData($id)
    {  
        $sql = "SELECT * FROM `home_slider` where id='$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }    
    public function updateAllSliderData(SliderModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }
    //For user

    public function listAllSliderDatas()
    {  
        $sql = "SELECT * FROM `home_slider` where status=1"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }      
}
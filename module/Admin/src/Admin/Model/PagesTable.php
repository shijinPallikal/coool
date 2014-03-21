<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class PagesTable extends AbstractTableGateway
{
    protected $table = 'pages';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }



    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->user))
            $return['uid'] = $obj->user;

        if(isset($obj->title))
            $return['title'] = $obj->title;

        if(isset($obj->description))
            $return['description'] = $obj->description;

        if(isset($obj->subTitle))
            $return['sub_title'] = $obj->subTitle;

        if(isset($obj->url))
            $return['url'] = $obj->url;

        if(isset($obj->status))
            $return['status'] = $obj->status;

        if(isset($obj->createdOn))
            $return['created_on'] = $obj->createdOn;

        if(isset($obj->updatedOn))
            $return['updated_on'] = $obj->updatedOn;

        return $return;
    }
	 
    public function savePagesDatas(PagesModel $obj)
    {  
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }
    public function listAllPagesData()
    {  
        $sql = "SELECT * FROM pages order by id desc ";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
    public function listPagesDatas()
    {  
        $sql = "SELECT * FROM pages where status=1 ";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    } 
    public function updatePageStatusOff($id)
    {  
        $sql = "update pages set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
    public function updatePageStatusOn($id)
    {  
        $sql = "update pages set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

   public function updatePagesDatas(PagesModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }   

    public function editPageData($id)
    {
        $sql = "SELECT * FROM pages WHERE id= '$id'";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;
    }       
}
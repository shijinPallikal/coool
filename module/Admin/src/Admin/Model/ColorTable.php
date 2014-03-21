<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ColorTable extends AbstractTableGateway
{
    protected $table = 'colors';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->color))
          $return['color'] = $obj->color;

        if(isset($obj->colorField))
          $return['color_field'] = $obj->colorField;

        if(isset($obj->colorStatus))
          $return['color_status'] = $obj->colorStatus;

        if(isset($obj->colorPicker))
          $return['color_picker'] = $obj->colorPicker;


        return $return;
    }

    public function addColor($color)
    {
        $sql = "update colors set color='$color' where id= 1"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
    /*public function getColor()
    {
        $sql = "select color from colors where color_status='1'and color_picker='1' order by id limit 1"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        $row = $result->current(); 
        //print_r($row);
        if(!empty($row['color'])) return $row['color']; else return 'default';
    }*/

    public function getColor()
    {
        $sql = "select * from colors"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        //$row = $result->current(); 
        //print_r($row);
        //if(!empty($row['color'])) return $row['color']; else return 'default';
        return $result;
    }
    public function listAllColorData() 
    {
        $sql = "SELECT * FROM colors LIMIT 1";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute();
        return $result;
    } 

    public function updateColorOff($id)
    {
        $sql = "update colors set color_status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function updateColorOn($id)
    {
        $sql = "update colors set color_status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function updateDefaultColorOff($id)
    {
        $sql = "update colors set color_field='0',color_status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function updateDefaultColorOn($id)
    {
        $sql = "update colors set color_field='1',color_status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function updateColorPickerOff($id)
    {
        $sql = "update colors set color_picker='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function updateColorPickerOn($id)
    {
        $sql = "update colors set color_picker='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
   
   
}
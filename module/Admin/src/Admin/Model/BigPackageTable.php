<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class BigPackageTable extends AbstractTableGateway
{
    protected $table = 'big_package';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }



    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->userId))
            $return['uid'] = $obj->userId;

        if(isset($obj->user))
            $return['user'] = $obj->user;

        if(isset($obj->productTitle))
            $return['product_title'] = $obj->productTitle;

        if(isset($obj->description))
            $return['description'] = $obj->description;

        if(isset($obj->image1))
            $return['image1'] = $obj->image1;

        if(isset($obj->image2))
            $return['image2'] = $obj->image2;

        if(isset($obj->area))
            $return['area'] = $obj->area;

        if(isset($obj->status))
            $return['status'] = $obj->status;

        if(isset($obj->productOrder))
            $return['product_order'] = $obj->productOrder;

        if(isset($obj->url))
            $return['url'] = $obj->url;

        if(isset($obj->offerDate))
            $return['offer_date'] = $obj->offerDate;

        if(isset($obj->default))
            $return['defaults'] = $obj->default;

        if(isset($obj->createdOn))
            $return['created_on'] = $obj->createdOn;

        if(isset($obj->updatedOn))
            $return['updated_on'] = $obj->updatedOn;

        return $return;
    }
	 
    public function saveBigPackageData(BigPackageModel $obj)
    {  
        $sql = new Sql($this->adapter);            
        $insert = $sql->insert($this->table);                       
        $insert->values ($this->exchangeToArray($obj));
        $statement = $sql->prepareStatementForSqlObject($insert);          
        $result = $statement->execute();                    
        $lastId=$this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        return $lastId;
    }
    public function updateBigPackageImage1($id,$img1)
    {  
        $sql = "update `big_package` set image1='$img1' where id= $id";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }  
    public function updateBigPackageImage2($id,$img2)
    {  
        $sql = "update `big_package` set image2='$img2' where id= $id";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }  
    
    public function listAllBigPackage()
    {  
        $sql = "SELECT * FROM `big_package` where user= 'agentadmin' and defaults='0' "; 
        //echo $sql; exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }
    public function listAllBigPackageDefault()
    {  
        $sql = "SELECT * FROM `big_package` where user= 'agentadmin' and defaults='1' "; 
        //echo $sql; exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }
    public function listAllBigPackageDefaultAdmin()
    {  
        $sql = "SELECT * FROM `big_package` where user= 'agentSuperAdmin' and status='1' "; 
        //echo $sql; exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }

    public function listBigPackageData($id)
    {  
        $sql = "SELECT * FROM `big_package` where id='$id'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }

    public function updateBigPackageStatusOff($id)
    {  
        $sql = "update `big_package` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
    public function updateBigPackageStatusOn($id)
    {  
        $sql = "update `big_package` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function deleteBigPackageData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }

   public function updateBigPackageData(BigPackageModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));

        $statement = $sql->prepareStatementForSqlObject($update);
        //print_r($statement);exit;
        $statement->execute();
    }   

    public function listBigPackages($todayDate)
    {
        $sql = "SELECT * FROM big_package AS bp INNER JOIN offer_dates AS od ON bp.id=od.package_id WHERE od.offer_date = '$todayDate' AND bp.defaults= '0' AND bp.status= '1' AND od.package= 'big' ORDER BY bp.created_on DESC LIMIT 1 ";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;
    }   

    public function listBigPackages1()
    {
        $sql = "SELECT * FROM big_package AS bp INNER JOIN offer_dates AS od ON bp.id=od.package_id WHERE bp.status= '1' AND od.package= 'big'  AND bp.defaults= '1echo' ORDER BY bp.created_on DESC LIMIT 1 ";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;
    }   
    public function listAllSuperAdminBigPackage()
    {
        $sql = "SELECT * FROM big_package WHERE user='agentSuperAdmin'";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;

    }

    
}
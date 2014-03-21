<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class SmallPackageTable extends AbstractTableGateway
{
    protected $table = 'small_package';
   	
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

        if(isset($obj->defaults))
            $return['defaults'] = $obj->defaults;

        if(isset($obj->createdOn))
            $return['created_on'] = $obj->createdOn;

        if(isset($obj->updatedOn))
            $return['updated_on'] = $obj->updatedOn;

        return $return;
    }
	 
    public function saveSmallPackageData(SmallPackageModel $obj)
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
    public function updateSmallPackageImage1($id,$img1)
    {  
        $sql = "update `small_package` set image1='$img1' where id= $id";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }  
    public function updateSmallPackageImage2($id,$img2)
    {  
        $sql = "update `small_package` set image2='$img2' where id= $id";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }  
    
    public function listAllSmallPackageAreaDefault1()
    {  
        $sql = "select * from `small_package` where area= 1 and defaults=0 and user='agentadmin'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function listAllSmallPackageAreaDefault11()
    {  
        $sql = "select * from `small_package` where area= 1 and defaults=1 and user='agentadmin'";
        //echo $sql; exit;
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    
    public function listAllSmallPackageAreaDefault2()
    {  
        $sql = "select * from `small_package` where area= 2 and defaults=0 and user='agentadmin'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function listAllSmallPackageAreaDefault22()
    {  
        $sql = "select * from `small_package` where area= 2 and defaults=1 and user='agentadmin'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function listSmallPackageData($id)
    {  
        $sql = "SELECT * FROM `small_package` where id='$id' and user='agentadmin'"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result; 
    }

    public function updateSmallPackageStatusOff($id)
    {  
        $sql = "update `small_package` set status='0' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }
    public function updateSmallPackageStatusOn($id)
    {  
        $sql = "update `small_package` set status='1' where id= $id"; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;   
    }

    public function deleteSmallPackageData($delId)
    {  
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table);    
        $delete->where(array('id' => $delId));     
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        return $result;
    }

    public function updateSmallPackageData(SmallPackageModel $obj)
    {  
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));

        $statement = $sql->prepareStatementForSqlObject($update);
        //print_r($statement);exit;
        $statement->execute();
    }      

    public function listSmallPackages1($todayDate)
    {
        $sql = "SELECT * FROM small_package AS sp INNER JOIN offer_dates AS od ON sp.id=od.package_id WHERE od.offer_date = '$todayDate' AND sp.status= '1' AND od.package= 'small' AND sp.area = 1 AND sp.defaults='0'  ORDER BY sp.created_on DESC LIMIT 1 ";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;
    }

    public function listSmallPackages2()
    {
        $sql = "SELECT * FROM small_package AS sp INNER JOIN offer_dates AS od ON sp.id=od.package_id WHERE sp.status= '1' AND od.package= 'small' AND sp.area = 1 AND sp.defaults='1'  ORDER BY sp.created_on DESC LIMIT 1 ";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;
    }

    public function listSmallPackages3($todayDate)
    {
        $sql = "SELECT * FROM small_package AS sp INNER JOIN offer_dates AS od ON sp.id=od.package_id WHERE od.offer_date = '$todayDate' AND sp.status= '1' AND od.package= 'small' AND sp.area = 2 AND sp.defaults='0'  ORDER BY sp.created_on DESC LIMIT 1 ";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;
    }

    public function listSmallPackages4()
    {
        $sql = "SELECT * FROM small_package AS sp INNER JOIN offer_dates AS od ON sp.id=od.package_id WHERE sp.status= '1' AND od.package= 'small' AND sp.area = 2 AND sp.defaults='1'  ORDER BY sp.created_on DESC LIMIT 1 ";
        $statement= $this->adapter->query($sql);
        $result= $statement->execute();
        return $result;
    }

    public function listAllSuperAdminPackage()
    {
        $sql = "select * from small_package where area=1 and defaults=0 and user='agentSuperAdmin'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function listAllSuperAdminPackage2()
    {
        $sql = "select * from small_package where area=2 and defaults=0 and user='agentSuperAdmin' and status=1";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function listAllAdminSmallPackage()
    {
        $sql = "select * from small_package where area=1 and status=1 and user='agentSuperAdmin'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    public function listAllAdminSmallPackage2()
    {
        $sql = "select * from small_package where area=2 and status=1 and user='agentSuperAdmin'";
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
    
}
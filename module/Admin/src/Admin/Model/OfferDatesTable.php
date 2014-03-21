<?php
namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class OfferDatesTable extends AbstractTableGateway
{
    protected $table = 'offer_dates';
   	
  	public function __construct(Adapter $adapter)
  	{
        $this->adapter = $adapter;
    }


    public function exchangeToArray($obj)
    {
        $return = array();

        if(isset($obj->package))
        $return['package'] = $obj->package;

        if(isset($obj->packageId))
        $return['package_id'] = $obj->packageId;

        if(isset($obj->offerDate))
            $return['offer_date'] = $obj->offerDate;

        return $return;
    }
	
    public function saveOfferDateDatas(OfferDatesModel $obj)
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

    public function updateOfferDateDatas(OfferDatesModel $obj)
    {
        //print_r($obj); exit;
        $sql = new Sql($this->adapter);         
        $update = $sql->update($this->table);   
        $update->set ($this->exchangeToArray($obj));
        $update->where(array('id' => $obj->id));
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }
    public function listSmallPackageDates($id)
    {
        $sql = "SELECT * FROM `offer_dates` where package_id='$id' AND package= 'small' "; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function listBigPackageDates($id)
    {
        $sql = "SELECT * FROM `offer_dates` where package_id='$id' AND package= 'big' "; 
        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function listAllSmallPackageDatesArea1()
    {
        $sql = "SELECT * FROM small_package AS sp LEFT JOIN offer_dates AS od ON sp.id= od.package_id
                 where od.package= 'small' AND sp.area= 1 "; 

        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function listAllBigPackageOfferDates()
    {
        $sql = "SELECT * FROM big_package AS bp LEFT JOIN offer_dates AS od ON bp.id= od.package_id
                 where od.package= 'big'"; 

        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }

    public function listAllSmallPackageDatesArea2()
    {
        $sql = "SELECT * FROM small_package AS sp LEFT JOIN offer_dates AS od ON sp.id= od.package_id
                 where od.package= 'small' AND sp.area= 2 "; 

        $statement = $this->adapter->query($sql);           
        $result = $statement->execute(); 
        return $result;
    }
}
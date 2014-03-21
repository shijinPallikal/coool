<?php
namespace Service\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ServiceHistoryModel implements InputFilterAwareInterface
{
	public $id;
	public $uniqueId;
	public $firstName;
	public $lastName;
	public $familyName;
	public $problemType;
	public $productType;
	public $complaint;
	public $whenDone;
	public $finishDate;
	public $nextCall;
	public $assignTo;
	public $status;
	public $createdOn;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}
	public function setUniqueId($uniqueId)
	{
		$this->uniqueId = $uniqueId;
	}
	public function setFirstName($firstName)
	{
		//echo $firstName;
		$this->firstName= $firstName;
	}
	public function setLastName($lastName)
	{
		//echo $lastName;
		$this->lastName= $lastName;
	}
	public function setFamilyName($familyName)
	{
		//echo $familyName;
		$this->familyName= $familyName;
	}
	public function setProblemType($problemType)
	{
		//echo $problemType;
		$this->problemType= $problemType;
	}
	public function setProductType($productType)
	{
		//echo $productType;
		$this->productType= $productType;
	}
	public function setComplaint($complaint)
	{
		//echo $complaint;
		$this->complaint= $complaint;
	}
	public function setWhenDone($whenDone)
	{
		//echo $whenDone;
		$this->whenDone= $whenDone;
	}
	public function setFinishDate($finishDate)
	{
		//echo $finishDate;
		$this->finishDate= $finishDate;
	}
	public function setNextCall($nextCall)
	{
		//echo $nextCall;
		$this->nextCall= $nextCall;
	}
	public function setAssignTo($assignTo)
	{
		//echo $assignTo;
		$this->assignTo= $assignTo;
	}
	public function setStatus($status)
	{
		$this->status= $status;
	}
	public function setCreatedOn($createdOn)
	{
		//echo $createdOn;
		$this->createdOn= $createdOn;
	}
	public function setUpdatedOn($updatedOn)
	{
		$this->updatedOn= $updatedOn;
	}

	 // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter){
      //  throw new \Exception("Not used");
    }
	
    public function getInputFilter(){
//        if (!$this->inputFilter) {
//            $inputFilter = new InputFilter();
//            $factory     = new InputFactory();
//
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'id',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'Int'),
//                ),
//            )));
//
//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'default_group',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'StripTags'),
//                    array('name' => 'StringTrim'),
//                ),
//                'validators' => array(
//                    array(
//                        'name'    => 'StringLength',
//                        'options' => array(
//                            'encoding' => 'UTF-8',
//                            'min'      => 1,
//                            'max'      => 50,
//							'messages'=>array(
//								//'Der Benutzername darf maximal 45 Zeichen lang sein.',
//							),
//						
//						'name'    => 'not_empty',
//                        'options' => array(
//                            
//                        ),
//							
//                        ),
//                    ),
//                ),
//            )));
//			
//            	            
//            $this->inputFilter = $inputFilter;
//        }
//
//        return $this->inputFilter;
   }

}
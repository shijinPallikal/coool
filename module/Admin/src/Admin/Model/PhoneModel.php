<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PhoneModel implements InputFilterAwareInterface
{
	public $id;
	public $phone;
	public $category;
	public $pid;
	public $createdOn;

	protected $inputFilter;                      
	
	public function setId($id)
	{
		$this->id = $id;				
	}

	public function setCategory($category)
	{
		$this->category= $category;
	}

	public function setPhone($phone)
	{
		//print_r($phone);
		$this->phone= $phone;
	}
	public function setPid($pid)
	{
		//print_r($pid);
		$this->pid= $pid;
	}
	public function setCreatedOn($createdOn)
	{
		$this->createdOn= $createdOn;
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
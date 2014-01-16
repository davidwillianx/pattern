<?php 
	
use application\lib\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
	private $validator;

	public function assertPreConditions()
	{
		$this->assertTrue($file = class_exists('application\lib\Validator'),
			'File not found '.$file);
	}

	public function setUp()
	{
		$this->validator = new Validator();
	}

	public function testInstanceOfValidator()
	{
		$this->assertInstanceOf('application\lib\Validator',$this->validator,
			'Its not a type of Validator');
	}

	/**
	*@TODO continuar - adicionar test para error
	*@REFACTORY adicionar a class privada \failure\ para
	*realizar a mudança no status $valid = false e setar a mensagem 
	*/
	public function testSetElementConditionToRequired()
	{
		$name = 'Alonso';
		$this->validator->setElementCondition($name,'Nome','required;');
		$this->assertTrue($this->validator->isValid());
	}

	/**
	*@depends testSetElementConditionToRequired
	*@expectedException UnexpectedValueException
	*/
	public function testSetElementConditionToRequiredAndThrowException()
	{	
		$name = null;
		$this->validator->setElementCondition($name,'Nome','required');
		$this->validator->isValid();
		// $this->setExpectedException('\application\exceptions\ValidatorException');
	}
}?>
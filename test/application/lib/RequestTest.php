<?php 

use application\lib\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{

	private $request;

	public function assertPreConditions()
	{
		$this->assertTrue($file = class_exists('application\lib\Request'),
			'File not found '.$file
			);
	}

	public function setUp()
	{
		$_POST['nome'] = 'Alonso';
		$_POST['email'] = 'al@ibest.com';
		$this->request = new Request();

	}
	
	public function testHasInstanceOfRequest()
	{
		$this->assertInstanceOf('application\lib\Request',$this->request,
			'Is not instance of Request');
	}	

	public function testGetKey()
	{
		$value = 'Alonso';
		$this->assertEquals($this->request->getKey('nome'),$value);
	}

	public function testGetKeyNotWork()
	{
		$this->assertEquals(null,$this->request->getKey('idade'));
	}

	public function testSet()
	{
		$idade = 22;
		$this->request->set('idade',$idade);

		$this->assertEquals($idade,$this->request->getKey('idade'));
	}

	/**
	*@depends testSet
	*@expectedException OverflowException
	*/
	public function testSetNotWork()
	{
		$this->request->set('nome','PA');
		$comp = $this->request->getKey('nome') != 'PA' ? false : true; 

		$this->assertFalse($comp);
	}

	/**
	*@depends testSetNotWork
	*/
	public function testUpdate()
	{
		$this->assertEquals('Alonso',$this->request->getKey('nome'));
		$this->request->update('nome','PA');
		$this->assertEquals('PA',$this->request->getKey('nome'),
			'Value not updated  from PA');
	}

	/**
	*@depends testUpdate
	*@expectedException UnexpectedValueException*/
	public function testUpdateNotWork()
	{
		$this->request->update('idade',25);
	}

	public function testReleaseKey()
	{
		$this->request->releaseKey('nome','name');

		$this->assertEquals($_POST['nome'],$this->request->getKey('name'),
			'Something wrong to realease key');
	}

	/**
	*@depends testReleaseKey
	*@expectedException UnexpectedValueException
	*/
	public function testReleaseKeyNotWork()
	{
		$this->request->releaseKey('name','nome');
	}

	public function testIsElement()
	{
		$this->assertTrue($this->request->isElement('nome'),
			'Element not found');
	}

	public function  testIsElementNotWork()
	{
		$this->assertFalse($this->request->isElement('idade'));
	}

	public function testRemove()
	{
		$this->assertTrue($this->request->remove('nome'),
			'Error to remove this element');
	}

	/**
	*@depends testRemove
	*@expectedException \UnexpectedValueException
	*/
	public function testRemoveNotWork()
	{
		$this->request->remove('cpf');
	}

}?>
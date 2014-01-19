<?php 

use application\lib\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
	private $response;

	public function assertPreConditions()
	{
		$this->assertTrue($class = class_exists('application\lib\Response'),
			'Class not found '.$class);
	}

	public function setUp()
	{
		$this->response = new Response();
	}

	public function testClassResponseInstanceOf()
	{
		$this->assertInstanceOf('application\lib\Response',$this->response);
	}

	public function testClassHasAttributeView()
	{
		$this->assertClassHasAttribute('view','application\lib\Response');
	}

	public function testClassHasAttributeStorage()
	{
		$this->assertClassHasAttribute('storage','application\lib\Response');
	}

	public function testClassHasAttributeContent()
	{
		$this->assertClassHasAttribute('content','application\lib\Response');
	}

	public function testClassHasAttributeSource()
	{
		$this->assertClassHasAttribute('src','application\lib\Response');
	}

	public function  testSetView()
	{
		$view = 'index.php';
		$this->assertTrue($this->response->setView($view));
	}

	/**
	*@expectedException InvalidArgumentException
	*/
	public function testSetViewNotWorkAndThrowInvalidException()
	{
		$this->response->setView('');
	}

	public function testSetStorage()
	{
		$storage = array('mensagem' => 'Cadastro Realizado com sucesso');
		$this->assertTrue($this->response->setStorage($storage));
	}

	/**
	*@expectedException InvalidArgumentException
	*/
	public function testSetStorageNotWorkAndTrowInvalidException()
	{
		$failStorage = array();
		$this->response->setStorage($failStorage);
	}

	public function testShow()
	{
		$storage = array('message'=>'realizado com sucesso!');
		$view = 'index.php';
		$this->response->setView($view);
		$this->response->setStorage($storage);
		$this->assertNull($this->response->show());
	}

	public function testUserResponseInstanceByConstructorParameters()
	{
		$storage = array('message','realizado com sucesso');
		$view =  'index.php';
		$this->response = new Response($view,$storage);	
	}

	/**
	*@expectedException InvalidArgumentException
	*/
	public function testUserResponserInstanceByFailConstructorParameters()
	{
		$storage = array();
		$view = 'alonso.php';

		$this->response = new Response($view,$storage);
	}

	/**
	*@expectedException RuntimeException
	*/	
	public function testShowNotWorkTrowException()
	{
		$this->response->show();
	}
}?>
<?php

use application\controller\ControllerUser;
use application\lib\Request;
use application\view\View;

class ControllerUserTest extends \PHPUnit_Framework_TestCase
{

	private $controllerUser;

	public function assertPreConditions()
	{
		$this->assertTrue($file = class_exists('application\controller\ControllerUser'),
 				'File no found '.$file
			);
	}

	public function setUp()
	{
		$this->controllerUser = new ControllerUser();
	}

	public function tearDown()
	{
		$_POST = null;
	}

	public function testIsIntanceOfControllerUser()
	{
		$this->assertInstanceOf('application\controller\ControllerUser',$this->controllerUser,
									'Unexpected type  expected ControllerUser');
	}

	public function  testClassHasAttributeView()
	{
		$this->assertClassHasAttribute('view',get_class($this->controllerUser));
	}

	public function testClassHasAttributeStorage()
	{
		$this->assertClassHasAttribute('dataStorage',get_class($this->controllerUser));
	}

	public function testClassHasAttributeModel()
	{
		$this->assertClassHasAttribute('model',get_class($this->controllerUser));
	}

	public function testRegister()
	{
		$request = new Request();
		$request->set('nome','controllerUser');
		$request->set('email','cuser@hotmail.com');
		$request->set('idade',8);
		$request->set('event','registerUser');

		$this->assertTrue($this->controllerUser->register($request),'Unexpected value:: register user');
	}

	/**
	*@depends testRegister
	*/
	public function testRegisterNotWorkWithInvalidDataRequired()
	{
		$request =  new Request();
		$request->set('nome',null);
		$request->set('email','');
		$request->set('event','registerUser');
		$this->assertFalse($this->controllerUser->register($request));
	}

	public function testList()
	{
		$this->assertNull($this->controllerUser->showlist());
	}

	public function testLaucher()
	{
		$page = 'index.php';
		$storage = array('message'=>'cadastrado com sucesso');
		$this->controllerUser->launcher($page,$storage);	
	}

	/**
	*@expectedException RuntimeException
	*/
	public function testLaucherNotWork()
	{
		$this->controllerUser->launcher(null, null);
	}



}?>
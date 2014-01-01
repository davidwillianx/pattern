<?php

use application\controller\ControllerUser;
use application\lib\Request;

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
		$request->set('event','registerUser');

		$this->assertTrue($this->controllerUser->register($request),'Unexpected value:: register user');
	}

	/**
	*@depends testRegister
	*/
	public function testRegisterNotWorkWithInvalidDataRequired()
	{
		$data = array('nome' => null, 'email' => '','event'=>'registerUser');
		$_POST = $data;
		$this->assertFalse($this->controllerUser->register());
	}

	public function testList()
	{
		$this->assertNull($this->controllerUser->showlist());
	}

}?>
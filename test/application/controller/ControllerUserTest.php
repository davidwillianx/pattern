<?php

use application\controller\ControllerUser;

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

	public function testClassHasAttributeDataStorage()
	{
		$this->assertClassHasAttribute('model',get_class($this->controllerUser));
	}

	public function testRegister()
	{
		$data = array('Nome'=>'alonso','email'=>'test@hotmail.com','event'=>'registerUser');
		$_POST = $data;

		$this->assertTrue($this->controllerUser->register(),'Unexpected value:: register user');
	}






}?>
<?php 

use application\model\action\UserAction;
use application\model\dao\UserDao;
use application\model\dao\Dao;

class UserActionTest extends \PHPUnit_Framework_TestCase
{

	private $userAction;

	public function assertPreConditions()
	{
		$this->assertTrue($file = class_exists('application\model\action\UserAction'),
			'Class UserAction not found');
	}

	public function setUp()
	{
		$this->userAction = new UserAction();
		
	}

	public function testIsInstanceOfUserAction()
	{
		$this->assertInstanceOf('application\model\action\UserAction',$this->userAction,
			'Is not a type defined UserAction');
	}

	public function testGetDao()
	{
		$userDao = new UserDao(new Dao());
		$this->assertEquals($this->userAction->getDao(),$userDao,
			'Unexpected type of data');
	}

	public function testUserActionHasAttributeUserDao()
	{
		$this->assertClassHasAttribute($attributeName = 'userDao',get_class($this->userAction));
	}

	public function testUserActionHasAttributeDao()
	{
		$this->assertClassHasAttribute($attributeName = 'dao',get_class($this->userAction));	
	}

	/**
	*@expectedException RuntimeException
	*@expectedExceptionMessage Dados inv&aacute;lidos para realiza&ccedil&atilde; do cadastro
	*/
	public function testRegisterNotWork()
	{
		$this->assertTrue($this->userAction->register('',''));
	}

	/**
	*@depends testRegisterNotWork
	*/
	public function testRegister()
	{
		$name = 'Alonso';
		$email = 'al@ig.com.br';
		$this->assertTrue($this->userAction->register($name,$email));
	}

	public function testGetAll()
	{
		$users = $this->userAction->getAll();
		$this->assertArrayHasKey(0,$users);
		$this->assertCount(3,$users['0']);
	}
}?>
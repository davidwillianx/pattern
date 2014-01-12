<?php 

use application\model\action\UserAction;
use application\model\dao\UserDao;
use application\model\dao\Dao;
use application\lib\Request;

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
		$_POST = null;
		
	}

	public function tearDown()
	{
		$this->userAction = null;
		$_POST = null;
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
		$request = new Request();
		$this->assertTrue($this->userAction->register($request));
	}

	/**
	*@depends testRegisterNotWork
	*/
	public function testRegister()
	{
		$this->assertTrue($this->register());
	}

	public function testGetAll()
	{
		$this->register();
		$users = $this->userAction->getAll();
		$this->assertArrayHasKey(0,$users);
		$this->assertCount(3,$users['0']);
	}

	/**
	*@depends testRegister
	*@expectedException RuntimeException
	*/
	public function testRegisterNotWorkToTestTransactionCondition()
	{
		$request = new Request();
		$request->set('nome','TomTom');
		$request->set('email','tom@ig.com.br');
		//$request->set('idade',22);
		$this->userAction->register($request);
	}

	public function register()
	{
		$request = new Request();
		$request->set('nome','registUserAndPessoa');
		$request->set('email','al@ig.com.br');
		$request->set('idade',22);

		return $this->userAction->register($request);
	}

	
}?>
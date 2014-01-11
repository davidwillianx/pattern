<?php 

use application\model\dao\UserDao;
use application\model\dao\Dao;
use application\model\entity\User;


class UserDaoTest extends \PHPUnit_Framework_TestCase
{
	private $userDao;

	public function assertPreConditions()
	{
		$this->assertTrue($file = class_exists('application\model\dao\UserDao'),
				'File not found '.$file
			);
	}

	public function setUp()
  	{
  		$dao = new Dao();
  		$this->userDao = new UserDao($dao);
  	}

  	public function tearDown()
	{
		$dao =  new Dao();
		$dao->sql = 'TRUNCATE user';
		$dao->prepare();
		$dao->execute();
	}

  	public function testIsInstanceOfUserDao()
  	{
  		$this->assertInstanceOf('application\model\dao\UserDao',$this->userDao,
  				'Something wrong in your class file or in your path'
  			);
  	}

  	public function testInsert()
	{
		$user = new User();
		$user->setNome('anybody');
		$user->setEmail('any@body.com.br');

		$this->assertTrue($this->userDao->insert($user));
	}

	/**
	*@depends testInsert
	*/
  	public function testSelectAll()
  	{

  		$quantityRows = $this->userDao->countAll();
   		$this->assertCount((int)$quantityRows['quantity'],$this->userDao->selectAll(),
  			'Unexpected number of responses'
  		);
  	}

  	/**
  	*@depends testSelectAll
  	*/
	public function testSelectById()
	{
		$user = new User();
		$user->setId(1);
		$user->setNome('anybody');
		$user->setEmail('any@body.com.br');
		$this->userDao->insert($user);

		$userRow = $this->userDao->selectById($user);
		$this->assertCount(3,$userRow,
				'unexpected number of values'
			);
	}

	/**
	*@expectedException InvalidArgumentException
	*/
	public function testInsertNotWork()
	{
		$user = new User();
		$this->userDao->insert($user);
	}

	/**
	*@depends testInsertNotWork
	*/
	public function testClassHasAttributeDao()
	{
		$this->assertClassHasAttribute('dao',get_class($this->userDao),
			'Class doesnt has attribute dao');
	}
}?>
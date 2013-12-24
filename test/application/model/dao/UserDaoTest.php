<?php 

use application\model\dao\UserDao;
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
  		$this->userDao = new UserDao();
  	}

  	public function testIsInstanceOfUserDao()
  	{
  		$this->assertInstanceOf('application\model\dao\UserDao',$this->userDao,
  				'Something wrong in your class file or in your path'
  			);
  	}

  	public function testSelectAll()
  	{
  		$quantityRows = $this->countRowsUserTable();
   		$this->assertCount($quantityRows,$this->userDao->selectAll(),
  			'Unexpected number of responses'
  		);
  	}

  	/**
  	*@depends testSelectAll
  	*/
	public function testSelectById()
	{
		/*$userMock = $this->getMock('application\mode\entity\User');
		$userMock->expects($this->any())
				 ->method('getId')
				 ->will($this->returnValue(1));*/
		$user = new User();
		$user->setId(1);

		$userRow = $this->userDao->selectById($user);
		$this->assertCount(3,$userRow,
				'unexpected number of values'
			);
	}

	private function countRowsUserTable()
	{
		$this->userDao->sql = 'SELECT COUNT(id) quantidade FROM user';
		$this->userDao->prepare();
		$this->userDao->execute();
		$quantity =  $this->userDao->fetch(\PDO::FETCH_ASSOC);
		return (int) $quantity['quantidade'];
	}
}?>
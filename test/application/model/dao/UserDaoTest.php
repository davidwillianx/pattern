<?php 

use application\model\dao\UserDao;

class UserDaoTest extends \PHPUnit_Framework_TestCase
{
	private $userDao;

	public function assertPreconditions()
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
  		$this->assertInstanceOf('UserDao',$this->userDao,
  				'Something wrong in your class file or in your path'
  			);
  	}

}?>
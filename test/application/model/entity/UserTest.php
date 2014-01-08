<?php 

	use application\model\entity\User;

	class UserTest extends \PHPUnit_Framework_TestCase
	{

		private $user;

		public function assertPreConditions()
		{
			$this->assertTrue( $file = class_exists('application\model\entity\User'),
					'File not found in '.$file
				);
		}

		public function setUp()
		{
			$this->user = new User();
		}
		
		public function testExiststAttributeEmail()
		{
			$this->assertClassHasAttribute('email','application\model\entity\User');
		}		

		public function testExistsAttributeEmail()
		{
			$this->assertClassHasAttribute('email','application\model\entity\User');
		}

		public function testExistsAttributeNome()
		{
			$this->assertClassHasAttribute('nome','application\model\entity\User');	
		}		

		public function testExistsAttributeId()
		{
				$this->assertClassHasAttribute('id','application\model\entity\User');	
		}

		public function testIsInsTanceOfUser()
		{
			$this->assertInstanceOf('application\model\entity\User',$this->user,
					' Is not Instance of User'
				);
		}

		/**
		*@depends testIsInsTanceOfUser
		*/
		public function testSetNome()
		{
			$this->assertTrue($this->user->setNome('UserTest'),
				'name not associated with its attribute'
				);
		}

		/**
		*@depends testSetNome
		*@expectedException UnexpectedValueException
		*/
		public function testSetNomeNotWork()
		{
			$this->user->setNome('');

		}

		/**
		*@depends testSetNome
		*/
		public function testSetEmail()
		{
			$this->assertTrue($this->user->setEmail('user@hotmail.com'),
				'email not associated with its attribute'
				);
		}

		/**
		*@expectedException UnexpectedValueException
		*@depends testSetEmail
		*/
		public function testSetEmailNotWork()
		{
			$this->user->setEmail('');
		}

		public function testSetId()
		{
			$this->assertTrue($this->user->setId(1),
				'id not associated with its attribute');
		}

		/**
		*@expectedException UnexpectedValueException
		*@depends testSetId
		*/
		public function testSetIdNotWork()
		{
			$this->user->setId('');
		}

		public function testGetNome()
		{
			$name = 'UserTest';
			$this->user->setNome($name);
			$this->assertSame($name,$this->user->getNome(),
				'Name is not same'
				);
		}

		public function testGetEmail()
		{
			$email = 'user@hotmail.com';
			$this->user->setEmail($email);
			$this->assertSame($email,$this->user->getEmail());
		}

		public function testGetId()
		{
			$id = 1;
			$this->user->setId($id);
			$this->assertSame($id,$this->user->getId());
		}

	}?>
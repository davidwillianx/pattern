<?php 
	
	use application\model\dao\AbstractDao;

	class AbstractDaoTest extends \PHPUnit_Framework_TestCase
	{
		private $abstractDao;
		private $dataConnection = array(
							'dns' => 'mysql:dbname=contecomtest;host=localhost'
							,'user' =>'root'
							,'passwd' =>'');

		public function assertPreConditions()
		{
			$this->assertTrue($file = class_exists('application\model\dao\AbstractDao'),
					'class not found '.$file
				);
		}

		public function setUp()
		{
			$this->abstractDao = new AbstractDao($this->dataConnection);
		}

		/**
		*@expectedException Exception
		*@expectedExceptionMessage Connection Failed
		*/
		public function testExpectedConstructorNotEstablishConnection()
		{
			$dataConnection = array(
							'dns' => 'mysql:dbname=undefined;host=localhost'
							,'user' =>'root'
							,'passwd' =>'');

			$abstractDao =  new AbstractDao($dataConnection);
		}

		/**
		*@depends testExpectedConstructorNotEstablishConnection
		*/
		public function testExistsAttributePdoConnection()
		{
			$this->assertClassHasAttribute($attrName = 'pdoConnection',get_class($this->abstractDao),
					'Attribute '.$attrName. ' Not found'
				);
		}

		/**
		*@depends testExistsAttributePdoConnection
		*/
		public function testGetConnection()
		{
			$this->assertInstanceOf('PDO',$this->abstractDao->getConnection(),
					'Connection refused, something wrong at constructor'
				);
		}

		/**
		*@depends testGetConnection
		*/
		public function testPrepare()
		{
			$this->abstractDao->sql = 'SELECT  * FROM user';
			$this->assertTrue($this->abstractDao->prepare(),
					'Error to preparate query'
				);
		}

		public function testBindParamShouldWork()
		{
			$this->abstractDao->sql = 'SELECT * FROM user WHERE id = ?';
			$this->abstractDao->prepare();
			$this->assertTrue($this->abstractDao->bindParam(1, PDO::PARAM_INT),
				'Param associated is not a type defined or is not an element valid');
		}

		/**
		*@expectedException InvalidArgumentException
		*@expectedExceptionMessage First argument cannot be null
		*/
		public function testBindParamShouldNotWork()
		{
			$this->abstractDao->sql = 'SELECT * FROM user id = ?';
			$this->abstractDao->prepare();
			$this->abstractDao->bindParam(null);
		}
	}?>
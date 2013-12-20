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
			$this->prepareQuery();
			$this->assertTrue($this->abstractDao->bindParam(1, \PDO::PARAM_INT),
				'Param associated is not a type defined or is not an element valid');
		}

		/**
		*@expectedException InvalidArgumentException
		*@expectedExceptionMessage First argument cannot be null
		*/
		public function testBindParamShouldNotWork()
		{	
			$this->prepareQuery();
			$this->abstractDao->bindParam(null);
		}


		public function testExecuteLastId()
		{
			$userRow = $this->checkLastInserted();
			$lastId = $userRow['id'];
			$this->abstractDao->sql = 'INSERT INTO user (nome,email)
										VALUES("Estroncio","e@hotmailcom")';
			$this->abstractDao->prepare();
			$idInsert = $this->abstractDao->executeLastId();
			$this->assertEquals(++$lastId,$idInsert);
		}

		/**
		*@depends testExecuteLastId
		*/
		public function testExecute()
		{
			$this->prepareQuery();
			$this->abstractDao->bindParam(1,\PDO::PARAM_INT);
			$this->assertTrue($this->abstractDao->execute());
		}

		
		/**
		*@depends testExecute
		*/
		public function testFetch()
		{
			$id = 1;
			$this->executeFromFetch($id);
			$this->assertCount(3,$this->abstractDao->fetch(\PDO::FETCH_ASSOC),
					'Expected 1 element(s)'
				);
		}

		/**
		*@depends testFetch
		*/
		public function testFetchNotFoundResult()
		{
			$userRow = $this->checkLastInserted();
			$lastId = $userRow['id'];
			$this->executeFromFetch(++$lastId);
			$this->assertFalse($this->abstractDao->fetch(\PDO::FETCH_ASSOC),
					'Unexpected elements found from this sentence'
				);
		}

		/**
		*@depends testFetchNotFoundResult
		*/
		public function testFetchAll()
		{
			$quatityRows = $this->countRowsUserTable();
			$this->abstractDao->sql = 'SELECT * FROM user';
			$this->abstractDao->prepare();
			$this->abstractDao->execute();

			$this->assertCount((int)$quatityRows['quantidade'],$this->abstractDao->fetchAll(),
				'Number rows fetched <someError>');
		}
     
		/*public function testFetchFromClassPatter()
		{
			$id = 1;
			$this->executeFromFetch($id);
			$this->assertInstanceOf('stdClass',$this->abstractDao->fetch(PDO::FETCH_CLASS));
		}*/

		private function prepareQuery()
		{
			$this->abstractDao->sql = 'SELECT * FROM user WHERE id = ?';
			$this->abstractDao->prepare();
		}

		
		private function executeFromFetch($id)
		{
			$this->abstractDao->sql = 'SELECT * FROM user WHERE id = ?';
			$this->abstractDao->prepare();
			$this->abstractDao->bindParam($id,\PDO::PARAM_INT);
			$this->abstractDao->execute();
		}

		private function checkLastInserted()
		{
			$this->abstractDao->sql = 'SELECT MAX(id) as id FROM user';
			$this->abstractDao->prepare();
			$this->abstractDao->execute();
			return $this->abstractDao->fetch(\PDO::FETCH_ASSOC);
		}

		private function countRowsUserTable()
		{
			$this->abstractDao->sql = 'SELECT COUNT(id) quantidade FROM user';
			$this->abstractDao->prepare();
			$this->abstractDao->execute();
			return $this->abstractDao->fetch(\PDO::FETCH_ASSOC);
		}
	}?>
<?php 
	
use application\model\dao\Dao;

class DaoTest extends \PHPUnit_Framework_TestCase
{
	private $dao;
	private $dataConnection = array(
						'dns' => 'mysql:dbname=contecomtest;host=localhost'
						,'user' =>'root'
						,'passwd' =>'');

	public function assertPreConditions()
	{
		$this->assertTrue($file = class_exists('application\model\dao\Dao'),
				'class not found '.$file
			);
	}

	public function setUp()
	{
		$this->dao = new Dao($this->dataConnection);
	}

	public function tearDown()
	{
		$dao =  new Dao();
		$dao->sql = 'TRUNCATE user';
		$dao->prepare();
		$dao->execute();
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

		$dao =  new Dao($dataConnection);
	}

	/**
	*@depends testExpectedConstructorNotEstablishConnection
	*/
	public function testExistsAttributePdoConnection()
	{
		$this->assertClassHasAttribute($attrName = 'pdoConnection',get_class($this->dao),
				'Attribute '.$attrName. ' Not found'
			);
	}

	/**
	*@depends testExistsAttributePdoConnection
	*/
	public function testGetConnection()
	{
		$this->assertInstanceOf('PDO',$this->dao->getConnection(),
				'Connection refused, something wrong at constructor'
			);
	}

	/**
	*@depends testGetConnection
	*/
	public function testPrepare()
	{
		$this->dao->sql = 'SELECT  * FROM user';
		$this->assertTrue($this->dao->prepare(),
				'Error to preparate query'
			);
	}

	public function testClassDaoHasAttributeTransaction()
	{
		$this->assertClassHasAttribute('transaction',get_class($this->dao));
	}
	
	public function testBindParamShouldWork()
	{
		$this->prepareQuery();
		$this->assertTrue($this->dao->bindParam(1, \PDO::PARAM_INT),
			'Param associated is not a type defined or is not an element valid');
	}

	/**
	*@expectedException InvalidArgumentException
	*@expectedExceptionMessage First argument cannot be null
	*/
	public function testBindParamShouldNotWork()
	{	
		$this->prepareQuery();
		$this->dao->bindParam(null);
	}

	public function testExecuteLastId()
	{
		$lastId = 1;
		$idInsert = $this->insertUser();
		$this->assertEquals($lastId,$idInsert);
	}

	/**
	*@depends testExecuteLastId
	*/
	public function testExecute()
	{
		$id = 1;
		$this->assertTrue($this->executeFromFetch($id));
	}
	
	/**
	*@depends testExecuteLastId
	*/
	public function testFetch()
	{
		$id = 1;
		$this->insertUser();
		$this->executeFromFetch($id);
		$this->assertCount(3,$this->dao->fetch(\PDO::FETCH_ASSOC),
				'Expected 1 element(s)'
			);
	}

	/**
	*@depends testFetch
	*/
	public function testFetchNotFoundResult()
	{
		$this->executeFromFetch(1);
		$this->assertFalse($this->dao->fetch(\PDO::FETCH_ASSOC),
				'Unexpected elements found from this sentence'
			);
	}

	/**
	*@depends testFetchNotFoundResult
	*/
	public function testFetchAll()
	{
		$quatityRows = 0;
		$this->dao->sql = 'SELECT * FROM user';
		$this->dao->prepare();
		$this->dao->execute();

		$this->assertCount((int)$quatityRows['quantidade'],$this->dao->fetchAll(),
			'Number rows fetched <someError>');
	}

	public function testBeginTransaction()
	{
		$this->assertTrue($this->dao->beginTransaction());
		$this->assertFalse($this->dao->beginTransaction());
	}

	public function testCommit()
	{
		$this->dao->beginTransaction();
		$this->assertTrue($this->dao->commit());
	}

	public function testCommitNotWork()
	{
		$this->assertFalse($this->dao->commit());			
	}

	public function testRollBack()
	{
		$this->dao->beginTransaction();
		$this->assertTrue($this->dao->rollback());
	}

	public function testRollBackNotWork()
	{
		$this->assertFalse($this->dao->rollBack());
	}
 
	/*public function testFetchFromClassPatter()
	{
		$id = 1;
		$this->executeFromFetch($id);
		$this->assertInstanceOf('stdClass',$this->abstractDao->fetch(PDO::FETCH_CLASS));
	}*/

	private function prepareQuery()
	{
		$this->dao->sql = 'SELECT * FROM user WHERE id = ?';
		$this->dao->prepare();
	}

	private function executeFromFetch($id)
	{
		$this->dao->sql = 'SELECT * FROM user WHERE id = ?';
		$this->dao->prepare();
		$this->dao->bindParam($id,\PDO::PARAM_INT);
		return $this->dao->execute();
	}

	private function insertUser()
	{
		$this->dao->sql = 'INSERT INTO user(nome,email) VALUES (?, ?)';
		$this->dao->prepare();
		$this->dao->bindParam('dwlopes');
		$this->dao->bindParam('ss@hotmail.com');

		return $this->dao->executeLastId();
	}
}?>
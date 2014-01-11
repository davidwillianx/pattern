<?php 

use application\model\dao\Dao;
use application\model\entity\Pessoa;
use application\model\dao\PessoaDao;

class PessoaDaoTest extends \PHPUnit_Framework_TestCase
{

	private $pessoaDao;

	public function assertPreConditions()
	{
		$this->assertTrue($class = class_exists('application\model\dao\PessoaDao'),
			'Class not found '.$class);
	}

	public function setUp()
	{
		$dao = new Dao();
		$this->pessoaDao = new PessoaDao($dao);
	}

	public function tearDown()
	{
		$dao =  new Dao();
		$dao->sql = 'TRUNCATE pessoa';
		$dao->prepare();
		$dao->execute();
	}

	public function testInstanceOfPessoaDao()
	{
		$this->assertInstanceOf('application\model\dao\PessoaDao', $this->pessoaDao);
	}

	public function testInsert()
	{
		$pessoa = new Pessoa();
		$pessoa->setNome('Godinez');
		$pessoa->setIdade(9);

		$this->assertTrue($this->pessoaDao->insert($pessoa));
	}


}?>
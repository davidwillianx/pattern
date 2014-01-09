<?php 

use application\model\action\PessoaAction;
use application\model\dao\Dao;
use application\model\dao\PessoaDao;
use application\lib\Request;

class PesssoaActionTest extends \PHPUnit_Framework_TestCase
{
	private $pessoaAction;

	public function assertPreConditions()
	{
		$this->assertTrue($file = class_exists('application\model\action\PessoaAction'),
			'Class not found'.$file);		
	}

	public function setUp()
	{
		$this->pessoaAction = new PessoaAction();
	}
 
	public function testClassPessoaActionHasAttributePessoaDao()
	{
		$this->assertClassHasAttribute('pessoaDao',get_class($this->pessoaAction));
	}

	public function testClassPessoaActionHasAttributeDao()
	{
		$this->assertClassHasAttribute('dao',get_class($this->pessoaAction));
	}

	public function testGetDao()
	{
		$pessoaDao = new PessoaDao(new Dao());
		$this->assertEquals($this->pessoaAction->getDao(),$pessoaDao);
	}

	/**
	*@depends testGetDao
	*/
	public function testRegister()
	{
		$_POST = null;

		$request = new Request();
		$request->set('nome', 'estroncio');
		$request->set('idade',22);

		$this->assertTrue($this->pessoaAction->register($request));
	}
}?>
<?php 

use application\model\entity\Pessoa;

class PessoaTest extends \PHPUnit_Framework_TestCase
{
	private $pessoa;

	public function assertPreConditions()
	{
		$this->assertTrue($file = class_exists('application\model\entity\Pessoa'),
			'Class Not found '.$file
			);
	}

	public function setUp()
	{
		$this->pessoa = new Pessoa();
	}

	public function testInstanceOfPessoa()
	{
		$this->assertInstanceOf('application\model\entity\Pessoa', $this->pessoa);
	}

	public function testClassPessoaHasAttributeNome()
	{
		$this->assertClassHasAttribute('nome', get_class($this->pessoa));
	}

	public function testClassPessoaHasAttributeIdade()
	{
		$this->assertClassHasAttribute('idade',get_class($this->pessoa));
	}
	
	public function testSetNome()
	{
		$this->assertTrue($this->pessoa->setNome('Alonso'));
	}

	/**
	*@depends testSetNome
	*@expectedException InvalidArgumentException
	*/
	public function testSetNomeNotWork()
	{
		$this->pessoa->setNome(null);
	}

	public function testSetIdade()
	{
		$this->assertTrue($this->pessoa->setIdade(18));
	}

	/**
	*@depends testSetIdade
	*@expectedException InvalidArgumentException
	*/
	public function testSetIdadeNotWork()
	{
		$this->pessoa->setIdade('');
	}

	/**
	*@depends testSetIdadeNotWork
	*@expectedException InvalidArgumentException
	*/
	public function testSetIdadeNotWorkWithNotNumber()
	{
		$this->pessoa->setIdade('alonso');
	}

	public function testGetNome()
	{
		$this->pessoa->setNome('Alonso');
		$this->assertEquals('Alonso',$this->pessoa->getNome());
	}

	public function testGetIdade()
	{
		$this->pessoa->setIdade(18);
		$this->assertEquals(18,$this->pessoa->getIdade());
	}


}?>
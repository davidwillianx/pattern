<?php 

namespace application\model\action;
use application\model\entity\Pessoa;
use application\model\dao\PessoaDao;
use application\model\dao\Dao;

class PessoaAction
{

	private $pessoaDao;
	private $dao;
	
	public function __construct($dao = null)
	{
		if(!$dao)
			$this->dao = new Dao();
		else $this->dao = $dao;
	}	

	public function getDao()
	{
		if(!$this->pessoaDao)
			$this->pessoaDao = new PessoaDao($this->dao);
		return $this->pessoaDao;
	}

	public function register($request)
	{
		$this->dao->beginTransaction();
		try{
			$pessoa = new Pessoa();
			$pessoa->setNome($request->getKey('nome'));
			$pessoa->setIdade($request->getKey('idade'));

			$isInserted = $this->getDao()->insert($pessoa);	
			return $this->dao->commit();

		}catch(\InvalidArgumentException $error){
			$this->dao->rollBack();
			throw new \RuntimeException("Dados inv&aacute;lidos");

		}catch(\Exception $error){
			$this->dao->rollBack();
			throw new \RuntimeException("Problema na conexão");

		}
	}
}?>
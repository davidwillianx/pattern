<?php 

namespace application\model\dao;
use application\model\dao\IPessoaDao;
// use application\model\entity\Pessoa;
use application\model\dao\Dao;


class PessoaDao implements IPessoaDao
{
	private $dao;

	public function __construct(Dao $dao)
	{
		if($dao)
			$this->dao = $dao;
		else throw new \RuntimeException('User dao must be receive a dao instance');
	}

	public function insert($pessoa)
	{
		$this->dao->sql = 'INSERT INTO pessoa(nome,idade) VALUES(?,?)';
		$this->dao->prepare();
		$this->dao->bindParam($pessoa->getNome());
		$this->dao->bindParam($pessoa->getIdade(),\PDO::PARAM_INT);

		return $this->dao->execute();
	}


}?>
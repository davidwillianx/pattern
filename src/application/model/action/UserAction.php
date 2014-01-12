<?php 

namespace application\model\action;
use application\model\dao\UserDao;
use application\model\dao\Dao;
use application\model\entity\User;
use application\model\action\PessoaAction;
use application\lib\Request;

class UserAction
{
	private $userDao;
	private $dao;

	public function __construct($dao = null)
	{
		if(!$dao)
			$this->dao = new Dao();
		else $this->dao = $dao;
	}

	public function getDao()
	{
		if(!$this->userDao)
			return  $this->userDao = new UserDao($this->dao);
		return $this->userDao;
	}

	public function register(Request $request)
	{
		$this->dao->beginTransaction();
		try{
			$user = new User();
				$user->setNome($request->getKey('nome'));
				$user->setEmail($request->getKey('email'));
			 $this->getDao()->insert($user);

			 $pessoaAction = new PessoaAction($this->dao);
			 $pessoaAction->register($request);

			$this->dao->commit();
			return true;

		}catch(\UnexpectedValueException $error){
			$this->dao->rollback();
			throw new \RuntimeException('Dados inv&aacute;lidos para realiza&ccedil&atilde; do cadastro');
		}catch(\OverflowException $error){
			$this->dao->rollback();
			throw new \RuntimeException("Error Processing Request");
		}
	}

	public function getAll()
	{
		try
		{
			return $this->getDao()->selectAll();

		}catch(\InvalidArgumentException $error)
		{
			throw new \RuntimeException('Dados inv&aacute;lidos para realiza&ccedil&atilde; do cadastro');
		}
	}
}?>
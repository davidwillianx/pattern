<?php 

namespace application\model\action;
use application\model\dao\UserDao;
use application\model\entity\User;

class UserAction
{
	private $userDao;

	public function getDao()
	{
		if(!$this->userDao)
			return  $this->userDao = new UserDao();
		return $this->userDao;
	}

	public function register($nome,$email)
	{
		try{
			$user = new User();
				$user->setNome($nome);
				$user->setEmail($email);
			return $this->getDao()->insert($user);

		}catch(\UnexpectedValueException $error)
		{
			throw new \RuntimeException('Dados inv&aacute;lidos para realiza&ccedil&atilde; do cadastro');
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
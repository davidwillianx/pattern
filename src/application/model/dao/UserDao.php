<?php 
namespace application\model\dao;
use application\model\dao\IUserDao;

class UserDao implements IUserDao
{
	private $dao;

	public function __construct($dao)
	{
		if($dao)
			$this->dao = $dao;
		else throw new \RuntimeException('User dao must be receive a dao instance');
	}

	public function selectAll()
	{
		$this->dao->sql = 'SELECT * FROM user';
		$this->dao->prepare();
		$this->dao->execute();
		return $this->dao->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function selectById($user) 
	{
		$this->dao->sql = 'SELECT * FROM user WHERE id = ?';
		$this->dao->prepare();
		$this->dao->bindParam($user->getId());
		$this->dao->execute();
		return $this->dao->fetch(\PDO::FETCH_ASSOC);
	}

	public function insert($user)
	{
		$this->dao->sql = 'INSERT INTO user(nome,email) VALUES (?,?)';
		$this->dao->prepare();
		$this->dao->bindParam($user->getNome());
		$this->dao->bindParam($user->getEmail());
		return $this->dao->execute();
	}

	public function countAll()
	{
		$this->dao->sql = 'SELECT count(*) as quantity FROM user';
		$this->dao->prepare();
		$this->dao->execute();
		return $this->dao->fetch(\PDO::FETCH_ASSOC);
	}
}?>

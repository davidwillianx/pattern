<?php 
	namespace application\model\dao;
	use application\model\dao\AbstractDao;
	use application\model\dao\IUserDao;

	class UserDao extends AbstractDao implements IUserDao
	{
		public function selectAll()
		{
			$this->sql = 'SELECT * FROM user';
			$this->prepare();
			$this->execute();
			return $this->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function selectById($user)
		{
			$this->sql = 'SELECT * FROM user WHERE id = ?';
			$this->prepare();
			$this->bindParam($user->getId());
			$this->execute();
			return $this->fetchAll(\PDO::FETCH_ASSOC);
		}
	}
?>
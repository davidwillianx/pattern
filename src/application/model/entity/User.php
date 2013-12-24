<?php
	
	namespace application\model\entity;

	class User
	{
		private $email;
		private $nome;
		private $id;

		public function setNome($nome)
		{
			if(!$nome)
				throw new \UnexpectedValueException('unexpected empty attribute nome');
			$this->nome = $nome;
			return true;
		}

		public function setEmail($email)
		{
			if(!$email)
				throw new \UnexpectedValueException('unexpected empty attribute email');
			$this->email = $email;
			return true;
		}

		public function setId($id)
		{
			if(!$id)
				throw new \UnexpectedValueException('unexpected empty attribute email');

			$this->id = $id;
			return true;
		}


		public function getNome()
		{
			return $this->nome;
		}

		public function  getEmail()
		{
			return $this->email;
		}

		public function getId()
		{
			return $this->id;
		}
	}?>
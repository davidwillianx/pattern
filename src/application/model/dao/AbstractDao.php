<?php

	namespace application\model\dao;

	class AbstractDao 
	{
		public $sql;
		private $pdoConnection;
		private $pdoStatement;
		private $indexParam;
		private $dataConnection = array(
							'dns' => 'mysql:dbname=contecom;host=localhost'
							,'user'=>'root'
							,'passwd'=>'');
		

		public function __construct($dataConnection = null)
		{
			if($dataConnection)
				$this->dataConnection = $dataConnection;

			try {
				$this->pdoConnection = new \PDO(
										$this->dataConnection['dns']
										,$this->dataConnection['user']
										,$this->dataConnection['passwd']
												);

			} catch (\PDOException $error) {
				throw new \Exception('Connection Failed');
				
			}
		}

		public function getConnection()
		{
			return $this->pdoConnection;
		}

		public function prepare($sql = null)
		{
			try {
					$this->setStatement($this->getConnection()->prepare($sql));
					$this->indexParam = 0;
					return true;
			} catch (PDOException $error) {
				throw new \Exception('Prepare method not execute');
			}
		}

		public function bindParam($dataFetch,$typeAttribute = null)
		{
			if($dataFetch)
				return $this->getSteatement()->bindParam(++$this->indexParam,$dataFetch,$typeAttribute);
			else throw new \InvalidArgumentException("First argument cannot be null");
		}

		private function setStatement($pdoStatement)
		{
			$this->pdoStatement = $pdoStatement;
		}

		private function getSteatement()
		{
			return $this->pdoStatement;
		}
	}?>
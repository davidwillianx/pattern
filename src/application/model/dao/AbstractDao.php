<?php

	namespace application\model\dao;

	class AbstractDao 
	{
		public $sql;
		private $pdoConnection;
		private $pdoStatement;
		private $indexParam;
		private $dataConnection = array(
							'dns' => 'mysql:dbname=contecomtest;host=localhost'
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
					$this->setStatement($this->getConnection()->prepare($this->sql));
					$this->indexParam = 0;
					return true;
			} catch (PDOException $error) {
				throw new \Exception('Prepare method not execute');
			}
		}

		public function bindParam($dataFetch,$typeAttribute = null)
		{
			if($dataFetch)
				return $this->getStatement()->bindParam(++$this->indexParam,$dataFetch,$typeAttribute);
			else throw new \InvalidArgumentException("First argument cannot be null");
		}

		public function execute()
		{
			return $this->getStatement()->execute();
		}

		public function executeLastId()
		{
			if($this->execute())
				return $this->pdoConnection->lastInsertId();
		}

		public function fetch($patter = null)
		{
			 return $this->getStatement()->fetch($patter);			
		}

		public function fetchAll($patter = null)
		{
			return $this->getStatement()->fetchAll($patter);
		}

		private function setStatement($pdoStatement)
		{
			$this->pdoStatement = $pdoStatement;
		}

		private function getStatement()
		{
			return $this->pdoStatement;
		}
	}?>
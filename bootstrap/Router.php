<?php

namespace bootstrap;

use application\controller;

class Router
{
	const DS  = DIRECTORY_SEPARATOR;
	
	private $pathFile;
	public $fileInstance;
	private $fileName;

	private $dataRequest = array(
			'controller' =>'',
			'action'=> ''
		);
	private $dataResponse;
	private $file;
	private $trasac;

	public function __construct()
	{

	}

	/**@TODO criar exceptions para as condições 
	negativas da requisição (arquivo invalido / method invalid)*/
	public function listener()
	{
		$this->getDataRequest();

		if(!empty($this->dataRequest['controller']) && !empty($this->dataRequest['action']))
		{
			$this->fileName = 'Controller'.ucwords($this->dataRequest['controller']);
			$this->pathFile = $this->buildFilePath();
			
			$this->loadController();
			return true;	

		}else throw new Exception("File not exists");
	}

	/**@TODO verificar o uso do atributo transac*/
	/**@TODO Ao invocar o controllerResponsavel pela requisição inserir 
	*	como parametro a instancia de request*/
	private function loadController()
	{
		if(file_exists($this->pathFile))
		{
			require_once($this->pathFile);
			try{
				$this->fileInstance = new \ReflectionClass('application\controller\\'.$this->fileName);
				$this->fileInstance = $this->fileInstance->newInstance();

				$reflectionMethod = new \ReflectionMethod($this->fileInstance,$this->dataRequest['action']);
				$reflectionMethod->invokeArgs($this->fileInstance,array($this->trasac));
			}catch(\ReflectionException $error){
				echo 'falha de reflexao';
			}
			
		}else throw new \Exception("File not exists");				
	}

	private function getDataRequest()
	{

		$this->dataRequest['controller'] = !empty($_REQUEST['controller']) ? $_REQUEST['controller'] : 'index';
		$this->dataRequest['action'] = !empty($_REQUEST['action']) ? $_REQUEST['action'] : 'index';	
	}

	private function buildFilePath()
	{
		return 	dirname(dirname(__FILE__))
				. self::DS.'src'. self::DS
				.'application'.self::DS
				. 'controller'. self::DS
				. $this->fileName.'.php';
	}
}?>
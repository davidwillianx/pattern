<?php

namespace bootstrap;

use application\controller;
use application\lib\Request;

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
	private $file;
	private $request;
	private $transac;

	public function __construct()
	{
		$this->request = new Request();
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
									//404
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
				$reflectionMethod->invokeArgs($this->fileInstance,array($this->transac));
			}catch(\ReflectionException $error){
				echo 'falha de reflexao';
			}
			
		}else throw new \Exception("File not exists");				
	}

	private function getDataRequest()
	{
		$controller = $this->request->getKey('controller');
		$action = $this->request->getKey('action');

		$this->dataRequest['controller'] = !empty($controller) ? $controller : 'index';
		$this->dataRequest['action'] = !empty($action) ? $action : 'index';
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
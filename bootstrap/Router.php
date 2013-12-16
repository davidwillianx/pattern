<?php

namespace bootstrap;

class Router
{
	
	const DS  = DIRECTORY_SEPARATOR;
	
	private $pathFile;
	private $fileInstance;
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


	/*@TODO criar exceptions para as condições 
	negativas da requisição (arquivo invalido / method invalid)*/
	public function listener()
	{
		$this->dataRequest['controller'] = !empty($_REQUEST['controller']) ? $_REQUEST['controller'] : 'index';
		$this->dataRequest['action'] = !empty($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
		
		if(!empty($this->dataRequest['controller']) && !empty($this->dataRequest['action']))
		{
			$this->fileName = 'Controller'.ucwords($this->dataRequest['controller']);
			$this->pathFile = dirname(dirname(__FILE__))
							. self::DS.'src'. self::DS
							. 'controller'. self::DS
							. $this->fileName;

			if(file_exists($this->pathFile))
			{
				require_once($file);
				$this->fileInstance = new \ReflectionClass($this->$fileName);
				$this->fileInstance = $this->fileInstance->newInstance();

				$reflectionMethod = new \ReflectionMethod($this->fileInstance,$this->dataRequest['action']);
				$reflectionMethod->invokeArgs($this->fileInstance,$this->trasac);
	
				//return true;	
			}else throw new \Exception("File not exists");		
		}else throw new Exception("Error Processing Request");
	}
}?>
<?php 

namespace application\lib;

class Response
{
	const DS = DIRECTORY_SEPARATOR;
	private $view;
	private $storage;
	private $content;
	private $src;

	public function __construct($view = null,$storage = null)
	{
		$this->src = dirname(dirname(dirname(__FILE__))).self::DS.'public'.self::DS;

		if($storage) $this->setStorage($storage);
		if($view) $this->setView($view);
	}

	public function setView($viewName)
	{
		if($viewName && file_exists($viewPath = $this->src.$viewName))
		{
			$this->view = $viewPath;
			return true;		
		}else throw new \InvalidArgumentException('View solicitada não existe '.$viewName);
	}

	public function setStorage(Array $storage)
	{
		if(!empty($storage))
		{
			$this->storage = $storage;
			return true;
		}else throw new \InvalidArgumentException('É necessário valor para ser inserido em storage');
	}

	public function getStorage()
	{
		return $this->storage;
	}

	public function show()
	{
		if(file_exists($this->view)){
			ob_start();
			if(require_once($this->view))
				$this->content = ob_get_contents();
			ob_end_clean();

			echo $this->content;	
		}else throw new \RuntimeException('Configuração de execução inválida');
	}

}?>
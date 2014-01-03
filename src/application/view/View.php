<?php
	namespace application\view;

	class View
	{
		const DS = DIRECTORY_SEPARATOR;
		private $page;
		private $storage;
		private $content;

		public $src = '';
		

		public function __construct($view = null,$storage = null)
		{

			$this->src = dirname(dirname(dirname(__FILE__))).self::DS.
								'public'.self::DS;

			if($view != null && !empty($view))
				$this->setPage($view);
			
			if($storage != null && !empty($storage))
				$this->setStorage($storage);
		}

		public function setStorage($storage)
		{
			if($storage)
			{
				$this->storage = $storage;
				return true;
			}else throw new \InvalidArgumentException('Valor não pode ser
							 adicionado em storage');
		}

		public function setPage($page)
		{
			if(file_exists($this->src.$page))
			{
				$this->page = $page;
				return true;		
			}else throw new \RuntimeException("view not found");

		}

		public function getStorage()
		{
			return $this->storage;
		}

		public function show()
		{
			if($this->page)
			{
				ob_start();
				if(require_once($this->src.$this->page))
					$this->content = ob_get_contents();
				ob_end_clean();

				echo $this->content;
			}else throw new \RuntimeException('Não existe uma página solicitada');
			
		}
		
	}?>
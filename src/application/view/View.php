<?php
	namespace application\view;

	class View
	{
		private $page;
		private $storage;

		public function __construct($view = null)
		{
			if($view != null && !empty($view))
				$this->page = $view;
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

		public function show()
		{
			return true;
		}
		
	}?>
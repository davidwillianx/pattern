<?php
	
	namespace application\controller;

	use application\view\View;

	class ControllerIndex
	{
		public $model;
		public $view;
		public $dataStorage;

		public function index()
		{
			$this->view = new View();
			$this->view->setPage('index.php');
			$this->view->show();
		}
	}?>
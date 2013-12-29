<?php
	
	namespace application\controller;

	use application\view\View;

	class ControllerIndex
	{
		public $model;
		public $view;
		public $dataStorage;

		/*@TODO adicionar pagina correta*/
		public function index()
		{
			$this->view = new View();

			$this->view->setPage('test_contr_index.php');
			$this->view->show();
		}
	}?>
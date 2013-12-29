<?php 

namespace application\controller;
use application\model\User;

class ControllerUser
{

	private $view;
	private $dataStorage;
	private $model;

	public function register()
	{

		if(isset($_POST['event']) && !empty($_POST['event']))
		{
			$valid = true;
			$valid = !empty($_POST['nome']) ? true : false;
			$valid = !empty($_POST['email']) ? true : false;

			if($valid)
			{
				return true;
				//model
			}else return false;
				//mensagem de erro para o usuario
		}
	}




}?>
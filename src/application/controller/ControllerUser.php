<?php 

namespace application\controller;
use application\model\action\UserAction;

class ControllerUser
{

	private $view;
	private $dataStorage;
	private $model;

	/**@TODO nome igual ao da action ::mudança */
	public function register()
	{
		if(isset($_POST['event']) && !empty($_POST['event']))
		{
			$valid = true;
			$valid = !empty($_POST['nome']) ? true : false;
			$valid = !empty($_POST['email']) ? true : false;

			if($valid)
			{
				try
				{
					$model = new UserAction();
					$model->register($_POST['nome'],$_POST['email']);

				}catch(\RuntimeException $error)
				{
					/*chama uma caixa de informação dentro da tela
						com a mensagem de $error */
				}
				
				//model
			}else return false;
				//mensagem de erro para o usuario
		}
	}




}?>
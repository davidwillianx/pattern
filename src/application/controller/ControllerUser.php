<?php 

namespace application\controller;
use application\model\action\UserAction;
use application\view\View;
use application\lib\Validator;
use application\lib\Request;

class ControllerUser
{

	private $view;
	private $dataStorage;
	private $model;

	/**@TODO nome igual ao da action ::mudança */
	public function register(Request $request)
	{

		if($request->isElement('event') && $request->getKey('event'))
		{

			$valid = true;
			$valid = $request->getKey('nome') ? true : false;
			$valid = $request->getKey('email') ? true : false;

			if($valid)
			{
				try
				{
					$model = new UserAction();
					$model->register($request->getKey('nome'),$request->getKey('email'));
					echo 'Cadastro Realizado com sucesso!';
					return true;

				}catch(\RuntimeException $error){
					/*chama uma caixa de informação dentro da tela
						com a mensagem de $error */
				}
				
				//model
			}else return false;
				/*mensagem de erro para o usuario e addcionar via cacheRequest 
				que ja foram cadastradas corretament (superFeature)*/
		}
	}

	public function showlist()
	{
		try
		{	
			$model = new UserAction();
			$userStorage = $model->getAll();

			$view = new View('users.php');
			$view->setStorage($userStorage);
			$view->show();

		}catch(\RuntimeException $error){
			/*chama uma caixa de informação dentro da tela
						com a mensagem de $error */
		}catch(\InvalidArgumentException $error){
			
		}
	}
}?>
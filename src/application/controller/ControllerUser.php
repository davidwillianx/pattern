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
			$validator = new Validator();
			$validator->setElementCondition($request->getKey('nome'),'Nome','required;');
			$validator->setElementCondition($request->getKey('email'),'Email','required;email;');

			
			if($validator->isValid())
			{
				try
				{
					$model = new UserAction();
					$model->register($request->getKey('nome'),$request->getKey('email'));
					$storage  = array('message' => 'Cadastro realizado com sucesso');

					$view = new View('index.php',$storage);
					$view->show();

					return true;

				}catch(\RuntimeException $error){
					/*
						chama uma caixa de informação dentro da tela
						com a mensagem de $error 
					*/
				}
				//model
			}else {
				$storage = array('message' => 'Dados inválidos');
				$view  = new View('index.php',$storage);
				$view->show();

				return false;				
			}
				/*
					use $validator->showErros();
					mensagem de erro para o usuario e addcionar via cacheRequest 
					que ja foram cadastradas corretament (superFeature)
				*/
		}
	}

	public function showlist()
	{
		try
		{	
			$model = new UserAction();
			$userStorage = $model->getAll();

			$view = new View('users.php',$userStorage);
			$view->show();

		}catch(\RuntimeException $error){
			/*chama uma caixa de informação dentro da tela
						com a mensagem de $error */
		}catch(\InvalidArgumentException $error){
			
		}
	}

	
}?>
<?php 

namespace application\controller;
use application\model\action\UserAction;
use application\view\View;
// use application\exceptions\ValidatorException;
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
			try
			{
				$validator = new Validator();
				$validator->setElementCondition($request->getKey('nome'),'Nome','required;');
				$validator->setElementCondition($request->getKey('email'),'Email','required;email;');
				$validator->setElementCondition($request->getKey('idade'),'idade','required;isNumber;');
				
				$validator->isValid();
				
				$model = new UserAction();
				$model->register($request);
				$storage  = array('message' => 'Cadastro realizado com sucesso');
				$view = new View('index.php',$storage);
				$view->show();

				return true;

			}catch(\RuntimeException $error){

				$storage = array('message' => 'Dados inválidos');
				$view  = new View('index.php',$error->getMessage());
				$view->show();
				return false;
				/*
					chama uma caixa de informação dentro da tela
					com a mensagem de $error 
				*/
			}catch(\UnexpectedValueException $error)
			{
				$storage = array('message' => 'Dados inválidos');
				$view  = new View('index.php',$error->getMessage());
				$view->show();

				return  false;				
			}
			//model
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
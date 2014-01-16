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

	public function laucher($page,$storage)
	{
		$view = new View($page,$storage);
		$view->show();
	}
 
	/**@TODO nome igual ao da action ::mudança */
	public function register(Request $request)
	{
		if($request->isElement('event') && $request->getKey('event'))
		{
			try
			{
				$this->validateDataFromRegister($request);
				
				$model = new UserAction();
				$model->register($request);
				$this->laucher('index.php',array('message','Cadastro realizado com sucesso'))

				return true;

			}catch(\RuntimeException $error){
				$this->laucher('index.php',array('message' => $error->getMessage()));
				return false;

			}catch(\UnexpectedValueException $error)
			{
				$this->laucher('index.php',array('message' => $error->getMessage()));
				return  false;				
			}
		}
	}

	private function validateDataFromRegister($request)
	{
		$validator = new Validator();
		$validator->setElementCondition($request->getKey('nome'),'Nome','required;');
		$validator->setElementCondition($request->getKey('email'),'Email','required;email;');
		$validator->setElementCondition($request->getKey('idade'),'idade','required;isNumber;');
		
		$validator->isValid();
	}

	public function showlist()
	{
		try
		{	
			$model = new UserAction();
			$userStorage = $model->getAll();
			$this->laucher('users.php',$userStorage)

		}catch(\RuntimeException $error){
			$this->laucher('index.php',$error->getMessage());

		}catch(\InvalidArgumentException $error){
			$this->laucher('index.php',$error->getMessage());					
		}
	}
}?>
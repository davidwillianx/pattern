<?php
	require_once '../../bootstrap/bootstrap.php';
	require_once '../../bootstrap/Router.php';
	use bootstrap\Router;

	try
	{
		$router = new Router();
		$router->listener();

	}catch(Exception $error){
		echo 'are you fucking kidding me?';
		echo $error->getMessage();
	}
?>
<?php

	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'bootstrap'.DIRECTORY_SEPARATOR.'bootstrap.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'bootstrap'.DIRECTORY_SEPARATOR.'Router.php';
	
	use bootstrap\Router;

	try
	{
		$router = new Router();
		$router->listener();

	}catch(Exception $error){
		//404 error
		echo 'are you fucking kidding me?';
		echo $error->getMessage();
	}
?>
<?php

	ini_set('display_erros',1);
	error_reporting(E_ALL| E_STRICT);
	date_default_timezone_get('America/Belem');

	define('ds', DIRECTORY_SEPARATOR);
	$path = dirname(dirname(__FILE__));

	$autoloadPath = $path.ds.'vendor'.ds.'autload.php';
?>
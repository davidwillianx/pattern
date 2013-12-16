<?php 

use \PHPUnit_Framework_TestCase as PHPunit;
use bootstrap\Router;
require 'Router.php';

class RouterTest extends PHPunit
{
	private $router;

	public function assertPrecoditions()
	{
		$this->assertTrue(
				$className = class_exists('bootstrap\Router'),
				'Class not found '.$className
			);
	}

	public function setUp()
	{
		$this->router = new Router();
	}

	public function testInstanceOfRouter()
	{
		$this->assertInstanceOf('bootstrap\Router',$this->router,
					'It inst type of '.get_class($this->router)
				);
	}

	/**
	*@depends testInstanceOfRouter
	*@expectedException Exception
	*@expectedExceptionMessage File not exists
	*/
	public function testListenerWithoutRequestValues()
	{
		$_REQUEST['controller'] = '';
		$_REQUEST['action'] = '';

		$this->assertTrue($this->router->listener());		
	}
}









?>
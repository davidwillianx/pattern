<?php 

 	use application\view\View;

	class ViewTest extends \PHPUnit_Framework_TestCase
	{

		private $view;

		public function assertPreConditions()
		{
			$this->assertTrue($file  = class_exists('application\view\View'),
				'Class no found '.$file
				);
		}

		public function setUp()
		{
			$this->view = new View();
		}

		public function testExistInstanceOfView()
		{
			$this->assertInstanceOf('application\view\View',$this->view,
				'Unexpected type'
				);
		}

		/*
		*@depends testExistInstanceOfView
		*/
		public function testClassHasAttributePage()
		{
			$this->assertClassHasAttribute('page',get_class($this->view),
				'Class doesnt has attirubte page');
		}

		/**
		*@depends testClassHasAttributePage*/
		public function testClassHasAttributeStorage()
		{
			$this->assertClassHasAttribute('storage',get_class($this->view),
				'Class doesnt has attirubte storage'
				);
		}

		public function testSetStorage()
		{
			$storage = array('name' => 'youtube','age' => 12);
			$this->assertTrue($this->view->setStorage($storage));
		}

		/**
		*@expectedException InvalidArgumentException
		*/
		public function testSetStorageWithInvalidValueParameter()
		{
			$storage = array();
			$this->view->setStorage($storage);							
		}

		public function testShow()
		{
			$storage =	array('name' => 'somebody' ,'age' => 21);
			$page = '';
			$this->assertTrue($this->view->show());

		}
	}?>
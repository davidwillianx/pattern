<?php 

	use application\controller\ControllerIndex;
	use application\view\View;

	class ControllerIndexTest extends \PHPUnit_Framework_TestCase
	{	
		private $controllerIndex;

		public function assertPreConditions()
		{
			$this->assertTrue($file = class_exists('application\controller\ControllerIndex'),
				'File no found in '.$file);
		}

		public function setUp()
		{
			$this->controllerIndex = new ControllerIndex();
		}

		public function testHasInstanceOfControllerIndex()
		{
			$this->assertInstanceOf('application\controller\ControllerIndex',$this->controllerIndex,
					'Is not Instance of ControllerIndex class'
				);
		}

		public function testControllerIndexHasAttributeModel()
		{
			$this->assertClassHasAttribute('model',get_class($this->controllerIndex));

		}

		public function testIndex()
		{
			$this->assertNull($this->controllerIndex->index());
		}
	}?>
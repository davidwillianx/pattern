<?php 

namespace application\exceptions ;

	class ValidatorException extends \Exception
	{
		protected $namespace =  __NAMESPACE__;

		public function __construct($message = null)
		{
			parent::__construct($message);
		}
	}
?>
<?php
namespace application\lib;

class Request
{
	private $dataRequest = array();

	function __construct()
	{
		if (!is_null($_GET))
			$this->merge($_GET);

		if(!is_null($_POST))
			$this->merge($_POST);
	}

	private function merge($data)
	{
		$this->dataRequest = array_merge($this->dataRequest,$data);
	}

	public function getKey($key)
	{
		if($this->isElement($key))
			return $this->dataRequest[$key];
		return null;
	}
	
	public function set($key,$data)
	{
		if ($this->isElement($key))
			throw new \OverflowException('chave solicitada já possui valor atribuido');
		else 
			$this->dataRequest[$key] = $data;
	}
	
	public function update($key,$data)
	{
		$this->isElementWithException($key);
		$this->dataRequest[$key] = $data;
	}
	
	public function releaseKey($key,$newKey)
	{
		$this->isElementWithException($key);
		$data = $this->getKey($key);
		$this->remove($key);
		$this->set($newKey, $data);
	}

	public function isElement($key)
	{
		if(isset($this->dataRequest[$key]))
			return true;
		return false;
	}

	private function isElementWithException($key)
	{
		if(!$this->isElement($key))
			throw new \UnexpectedValueException('A chave solicitada não existe');
	}

	public function explodeRequest()
	{
		var_dump($this->dataRequest);
		die;
	}
	
	public function remove($key)
	{
		$this->isElementWithException($key);
			unset($this->dataRequest[$key]);
			return true;
	}

	/** @TODO método depreciado por conta 
		das novas regras de banco de dados
	*/
	public function buildObject($isntaceObject)
	{
		$keys =  array_keys($this->dataRequest);

		$ref = new ReflectionClass($isntaceObject);
		$propertiesObject = $ref->getProperties(ReflectionProperty::IS_PRIVATE);

		foreach ($propertiesObject as $propertieObject)
		{
			foreach ($keys as $key)
			{
				if($key == $propertieObject->getName())
				{
					$reflectionMethod = new ReflectionMethod($isntaceObject, 'set'.ucwords($key));
					$reflectionMethod->invoke($isntaceObject,$this->dataRequest[$key]);
				}
			}
		}
		return $isntaceObject;
	}
}


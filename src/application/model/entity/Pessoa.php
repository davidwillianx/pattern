<?php 

namespace application\model\entity;

class Pessoa
{
	private $nome;
	private $idade;


	public function setNome($nome)
	{
		if(!$nome)
			throw new \InvalidArgumentException("unexpected empty attribute nome");
		$this->nome = $nome;
		return true;	
	}

	public function setIdade($idade)
	{
		if(!$idade || !is_numeric($idade))
			throw new \InvalidArgumentException("unexpected empty attribute idade");
		$this->idade = $idade;	
		return true;
	}

	public function getNome()
	{
		return $this->nome;	
	}

	public function getIdade()
	{
		return $this->idade;	
	}
}?>
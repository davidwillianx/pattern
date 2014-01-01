<?php

namespace application\lib;


class Validator
{
    const DATA_DIA = 2;
    const DATA_MES = 2;
    const DATA_ANO = 3;

    private $erros = array();
    private $valid = true;

    public function setElementCondition($element,$label,$stringConditions)
    {
        $conditions = explode(';', $stringConditions);

        foreach ($conditions as $condition)
        {
            switch ($condition)
            {
                case 'required': $this->required($element, $label);
                break;
                case 'isNumber': $this->isNumber($element, $label);
                break;
                case 'isSelected': $this->isSelected($element, $label);
                break;
                case 'cpf': $this->isCpf($element,$label);
                break;
                case 'cnpj': $this->isCnpj($element,$label);
                break;
                case  'rg': $this->isRg($element,$label);
                break;
                case 'cellphone': $this->isCellPhonneNumber($element,$label);
                break;
                case 'email': $this->isEmail($element,$label);
            }
        }
    }

    private function required($element,$label)
    {
        if (!$element)
        {
            $this->valid = false;
            $this->setErros('O campo'.$label.' é obrigatório');
        }
    }

    private function isSelected($element,$label)
    {
        if($element == 0)
        {
            $this->valid = false;
            $this->setErros('A  opção de '.$label.' deve ser selecionada');
        }
    }

    public function isNumber($element,$label)
    {
        if (!is_numeric($element))
        {
            $this->valid = false;
            $this->setErros('O campo '.$label.' deve ser um número');
        }
    }

    public function isCpf($element,$label)
    {
        $pattern = preg_match('/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/', $element);
        if(!$pattern)
        {
            $this->valid = false;
            $this->setErros('O campo '.$label.' não corresponde a um valor válido');
        }
    }

    public function isCnpj($element,$label)
    {
        $pattern = preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/', $element);
        if(!$pattern)
        {
            $this->valid = false;
            $this->setErros('O campo '.$label.'não corresponde a um valor válido');
        }
    }

    public function isRg($element,$label)
    {        
        $pattern = preg_match('/^\d{6}$/', $element);

        if(!$pattern)
        {        
            $this->valid = false;
            $this->setErros('O campo '.$label.' não corresponde a um valor válido');
        }
    }

    public function isEmail($element,$label)
    {
        $pattern = preg_match('/^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$/',$element );
        if(!$pattern)
        {
            $this->valid = false;
            $this->setErros('O campo '.$label.' não corresponde a um valor válido');
        }

    }

    public function isCellPhonneNumber($element,$label)
    {
        $pattern = preg_match('/^\(?\d{2}\)?[\s-]?\d{4}-?\d{4}$/', $element);
        if(!$pattern)
        {
            $this->valid = false;
            $this->setErros('O campo '.$label.' não corresponde a um valor válido');
        }
    }

    public function isDate($element,$label)
    {
        $diaMesAno = explode('/', $element);
        $indexElements = 0;
        $dataFail = false;

        if($diaMesAno)
        {
            foreach ( $diaMesAno as $unidade)
            {
                if(!is_numeric($unidade))
                {
                    switch ($unidade)
                    {
                        case $indexElements == 1:
                                if(!(strlen($unidade) == $this::DATA_DIA))
                                        $dataFail = true;

                        case $indexElements == 2:
                                if(!(strlen($unidade) == $this::DATA_MES))
                                        $dataFail = true;

                        case $indexElements == 3:
                                if(!(strlen($unidade) == $this::DATA_ANO))
                                        $dataFail = true;
                    }
                }

            }
        }else $dataFail = true;


        if($dataFail)
                $this->setErros('O campo '.$label.' contém uma data inválida');
    }

    public function setErros($error)
    {
        $this->erros[] = $error;
    }

    public function getErros()
    {
        return $this->erros;
    }


    public function isValid()
    {
        if($this->valid)
                return true;
        return false;
    }

    private function failure($label)
    {
    	$this->valid = false;
    	$this->setErros('O campo '.$label.' é obrigatorio');
    }

    public function showErros()
    {
        $fails = $this->getErros();
     
        if(isset($fails))
        {
    		echo '<div>';
            foreach ($fails as $fail)
                    echo $fail.'<br>';
            echo '</div>';
        }
    }
}?>
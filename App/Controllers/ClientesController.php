<?php

namespace App\Controllers;

use CRO\Controller\Action;
use CRO\DI\Container;
use CRO\Init\Bootstrap;

class ClientesController extends Action
{
    public function listar()
    {
        $dados = Container::getModel("Clientes");
        $retorno = @array_pop( @explode("/", Bootstrap::getUrl() ) );
            if($retorno == "ok" || $retorno == "erro")
                $this->view->retorno = $retorno;
        $this->view->header = "Clientes";
        $this->view->headerSmall = "Listar Clientes";
        $this->view->dados = $dados->fetchAll("nome,sobrenome,razao,nome_fantasia");
        $this->render("listar");
    }

    public function status()
    {
        $form = retorna_form($_POST);
        $dados = Container::getModel("Clientes");
        $this->view->dados = $dados->alteraStatus($form['status'],$form['id']);
        return false;
    }

    public function api()
    {
        $dados = Container::getModel("Clientes");
        $temID = @array_pop( @explode("/", Bootstrap::getUrl() ) );
		if(is_numeric($temID))//busca um cliente específico
		{
			$this->view->dados = $dados->find($temID);
			echo json_encode($this->view->dados);
		}
		elseif($temID == "pf" || $temID == "pj")
		{
			$clausula = $temID == "pf" ? " AND cpf IS NOT NULL AND cpf != '' " : " AND cnpj IS NOT NULL AND cnpj != '' ";
			$this->view->dados = $dados->fetchWhere($clausula, "nome,sobrenome,razao,nome_fantasia");
			$arr = array();
			foreach($this->view->dados as $p)
				$arr[] = $p;
			echo json_encode($arr);
		}
		else
		{
			$this->view->dados = $dados->fetchAll("nome,sobrenome,razao,nome_fantasia");
			$arr = array();
			foreach($this->view->dados as $p)
				$arr[] = $p;
			echo json_encode($arr);
		}
		die;
        $this->view->header = "Clientes";
        $this->view->headerSmall = is_numeric($temID) ? "Edição" : "Cadastro";
        $this->view->headerSmall .= " de cliente";
        $this->view->dados = is_numeric($temID) ? $dados->find($temID) : array();
        //$this->render("cadastrar");
    }

    public function cadastrar()
    {
        $temID = @array_pop( @explode("/", Bootstrap::getUrl() ) );
        $dados = Container::getModel("Clientes");
        $this->view->header = "Clientes";
        $this->view->headerSmall = is_numeric($temID) ? "Edição" : "Cadastro";
        $this->view->headerSmall .= " de cliente";
        $this->view->dados = is_numeric($temID) ? $dados->find($temID) : array();
        $this->render("cadastrar");
    }

    public function cadastro()
    {
        $form = retorna_form($_POST);
        $form['estado-string'] = strtoupper( $form['estado-string'] );

        $dados = Container::getModel("Clientes");
        $retorno = $dados->grava($form);
        $urlRet = $retorno ? "ok" : "erro";

        redireciona(BASE_SITE . $urlRet);
    }

    public function padrao()
    {
        //analisa a url
        $verUrl = @explode("/", Bootstrap::getUrl() );
        $retorno = @array_pop($verUrl);
        $this->listar($retorno);
    }
	
	public function mascara($val, $mask)
	{
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++)
		{
			if($mask[$i] == '#')
			{
				if(isset($val[$k]))
					$maskared .= $val[$k++];
			}
			else
			{
				if(isset($mask[$i]))
					$maskared .= $mask[$i];
			}
		}
		return $maskared;
	}


}
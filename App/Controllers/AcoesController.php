<?php

namespace App\Controllers;

use CRO\Controller\Action;
use CRO\DI\Container;

class AcoesController extends Action
{
    public function excluir()
    {
        $excluir = Container::getModel("Acoes");
        $form = retorna_form($_POST);
        $coluna = @$form['coluna'] ? $form['coluna'] : "";
        $ret = $excluir->excluir( $form, $coluna );
        $txt_retorno = stripcslashes($form['txt_retorno']);
        if($ret == "ok")
        {
            if($form['tipo'] == "idstoarray")
                $this->view->retorno = "Sucesso!,".$txt_retorno ." selecionadas foram ".$form['txt_exc']."!,success";
            else
                $this->view->retorno = "Sucesso!,".$txt_retorno ." foi ".$form['txt_exc']."!,success";
        }
        else
        {
            if($form['tipo'] == "idstoarray") {
                if ($ret == "erro")
                    $this->view->retorno = "Erro!,Ocorreu um problema e os registros não foram excluídos!,error";
                else//erro parcial
                    $this->view->retorno = "Ops...,Alguns registros não puderam ser excluídos!,error";
            }
            else
                $this->view->retorno = "Erro!,Ocorreu um problema e ".$txt_retorno ." não foi ".$form['txt_exc']."!,error";
        }

        $this->render("retorno",false);
    }

    public function inserir()//para inserir um único campo
    {
        $inserir = Container::getModel("Acoes");
        $form = retorna_form($_POST);
        $this->view->retorno = $inserir->inserir($form);
        $this->render("retorno",false);
    }

    public function inserirMulti()
    {
        $inserir = Container::getModel("Acoes");
        $form = retorna_form($_POST);
        $this->view->retorno = $inserir->inserirMulti($form);
        die;
    }

    public function status()
    {
        $status = Container::getModel("Acoes");
        $form = retorna_form($_POST);
        $this->view->retorno = $status->alteraStt($form);
        die;
    }

    public function ordem()
    {
        $status = Container::getModel("Acoes");
        $form = retorna_form($_POST);
        $this->view->retorno = $status->ordem($form);
        die;
    }

    //função usada para limpar os textos do summernote
    public function limpaTexto()
    {
        $texto = preg_replace( '/class\s*=\s*"[^\"]*[^\"]*"/', "", $_POST['texto'] );
		$texto = str_replace("<p >","<p>", $texto);
        $texto = strip_tags( $texto, "<p><br>" );
		$texto = trim($texto);
		$texto = trim($texto, "<p>");
		$texto = trim($texto, "</p>");
		$texto = trim($texto, "<br>");
		echo $texto;
        die;
    }

    //função usada para gravar imagens do summernote
    public function salvaImagem()
    {
        $form = retorna_form($_POST);
        $dados = Container::getModel("Acoes");
        $urlImagem = $dados->salvaImagem($_FILES,$form);
        echo RAIZ_SITE . "imagens/" . $form['pagina'] . "/" . $urlImagem;
        die;
    }

}
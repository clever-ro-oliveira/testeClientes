<?php
/**
 * Created by PhpStorm.
 * User: cleversonr
 * Date: 05/06/2017
 * Time: 10:53
 */

namespace App\Models;


use App\Conn;
use CRO\Model\Table;

class Acoes extends Table
{
    public function excluir($form, $coluna = "")
    {
        $tabela = $form['tabela'];
        $coluna = $coluna ? $coluna : "id";
        if($form['tipo'] == "idstoarray")//todos os ids foram convertidos em um array
        {
            //transforma a string em um array para percorrer cada id
            $ids = explode(",",$form['lista_de_ids']);
            $numreg = count($ids);
            $count = 0;
            foreach ($ids as $i)
            {
                $query = "DELETE FROM {$tabela} WHERE {$coluna} = '".$i."'";
                if( $this->db->query($query) )
                    $count++;
            }

            if($count == 0)
                return "erro";
            elseif ($count == $numreg)
                return "ok";
            else
                return "parcial";

        }
        else//foi passado um id diretamente
        {
            $query = "DELETE FROM {$tabela} WHERE {$coluna} = '".$form['lista_de_ids']."'";
            if( $this->db->query($query) )
                return "ok";
            else
                return "erro";
        }
    }

    public function inserir($form, $coluna = "")
    {
        $coluna = $coluna ? $coluna : "id";
        if($form["id"])//Edição
            $query = "UPDATE {$form['tabela']} SET {$form['campo']} = '".filtro( $form['filtro'] ,$form['valor'])."' WHERE {$coluna} = '".$form['id']."'";
        else
            $query = "INSERT INTO {$form['tabela']} SET {$form['campo']} = '".filtro( $form['filtro'] ,$form['valor'])."'";

        if( $this->db->query($query) )
            return "ok";
        else
            return "erro";

    }

    public function inserirMulti($form)
    {
        //mostra_array($form);

        $retorno = executa( Conn::getDb(), $form['valor'], $form['tabela'], intval( $form['id'] ) ? "edita" : "inserir" , intval( $form['id'] ) ? $form["col"]."=".intval( $form['id'] ) : "" );

        return $retorno ? $retorno : "erro";
        die;
    }

    public function alteraStt($form)
    {
        $coluna = $form['col'] ? $form['col'] : "id";
        $query = "UPDATE {$form['tabela']} SET status = '{$form['status']}' WHERE {$coluna} = '{$form['id']}'";
        return $this->db->query($query);
    }

    public function ordem($form)
    {
        $ids = explode( "|", $form['id'] );
        $qtd = count($ids);
        foreach($ids as $id)
        {
            $this->db->query( "UPDATE {$form['tabela']} SET ordem = '".$qtd."' WHERE id = '".$id."'");
            $qtd--;
        }
        usleep(250000);
    }

    public function salvaImagem($files, $form)
    {
        $tamanho = getimagesize($files['file']['tmp_name']);
        $larg = $tamanho[0] <= 1920 ? $tamanho[0] : 1920;
        $nomeCliente = forma_url( Conn::nomeCliente() );

        $largura 	= array($larg);
        $altura 	= array(99999);
        $crop 		= array("");
        $pb 		= array("");
        $caminho 	= array("../imagens/" . $form['pagina'] . "/");
        $caminho = salvaimagem($files['file'], $largura, $altura, $caminho, $crop,$pb, $nomeCliente . "-" .
            ucfirst( strtolower( $form['pagina'] ) ) . "-" . forma_url( $form['titulo'] ) );
        return $caminho;
    }

}
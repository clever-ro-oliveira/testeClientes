<?php

namespace App;

class Conn
{

    public static function getDb()
    {
        $db = Conn::nomeDb();
		if( Conn::buscaIP() == "local" )
            return new \mysqli("localhost","root","",$db);//SERVIDOR
        else
            return new \mysqli("","","",$db);//HOSPEDAGEM - AMOSTRA
    }

    public static function nomeDb()
    {
        if( Conn::buscaIP() == "local" )
            return "clientes";//SERVIDOR
        else
            return "";//HOSPEDAGEM
    }

    /* Coloquei essa chamada aqui pra facilitar quando se inicia um novo trabalho
    *
    * Esta será a cor padrão do painel administrativo
    *
    */
    public static function corSite()
    {
        return "#00549e";
    }

    public static function nomeCliente()
    {
        return "Sistema Clientes";
    }

    public static function base_site()
    {
        $protocolo = $_SERVER['SERVER_PORT'] == "443" ? "https" : "http";
        return $protocolo."://".$_SERVER['HTTP_HOST'] . @array_shift(@explode("index.php", $_SERVER['SCRIPT_NAME']));
    }

    public static function raiz_site()
    {
        $protocolo = $_SERVER['SERVER_PORT'] == "443" ? "https" : "http";
        return $protocolo."://".$_SERVER['HTTP_HOST'] . @array_shift(@explode("admin/index.php",
                $_SERVER['SCRIPT_NAME']));
    }

    public static function buscaIP()
    {
		$ip = @explode( ".", $_SERVER['SERVER_ADDR'] );
		array_pop($ip);
        $ip = @implode( ".", $ip );
        $servidor = strtolower( $_SERVER['SERVER_NAME'] );
        return $ip == "127.0.0" || $ip == "192.168.0" || $servidor == "localhost" ? "local" : "producao";
    }
}
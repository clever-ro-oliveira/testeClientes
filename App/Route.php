<?php

namespace App;


use CRO\Init\Bootstrap;

class Route extends Bootstrap
{

    protected function initRoutes()
    {
        session_start();

        define( 'DB_DATABASE', Conn::nomeDb() );
        define( 'COR_SITE', Conn::corSite() );
        define( 'BASE_SITE', Conn::base_site() );
        define( 'RAIZ_SITE', Conn::raiz_site() );
        define( 'NOME_CLIENTE', Conn::nomeCliente() );

        //Pontos
        $routes['api'] = array('route' => "/api", "controller" => "clientesController", "action" => "api");
        $routes['apiPJ'] = array('route' => "/api/pj", "controller" => "clientesController", "action" => "api");
        $routes['apiPF'] = array('route' => "/api/pf", "controller" => "clientesController", "action" => "api");
        $routes['clientesCad'] = array('route' => "/cadastro", "controller" => "clientesController", "action" => "cadastro");
        $routes['clientesCadastro'] = array('route' => "/cadastrar", "controller" => "clientesController", "action" => "cadastrar");
        $routes['clientesListagem'] = array('route' => "/", "controller" => "clientesController", "action" => "listar");
        $routes['clientesListIndex'] = array('route' => "/index", "controller" => "clientesController", "action" => "listar");
        $routes['clientesListOk'] = array('route' => "/ok", "controller" => "clientesController", "action" => "listar");
        $routes['clientesExc'] = array('route' => "/exclui", "controller" => "clientesController", "action" => "exclui");
		$routes['excluir'] = array('route' => "/acoes/excluir", "controller" => "acoesController", "action" => "excluir");



		$this->setRoutes($routes);

    }

}

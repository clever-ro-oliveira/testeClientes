<?php

namespace CRO\Init;


abstract class Bootstrap
{
    private $routes;
    protected $pag404;

    public function __construct()
    {
        $this->initRoutes();
        $this->run($this->getUrl());
    }

    abstract protected function initRoutes();

    protected function run($url)
    {
        $_SESSION[DB_DATABASE]['rotaMenu'] = "";
        $_SESSION[DB_DATABASE]['rotaUrl'] = "";
        //verifica se o usuário está logado
		$_SESSION[DB_DATABASE]['id_usuario'] = 1;
        if(!@$_SESSION[DB_DATABASE]['id_usuario'])
        {
            $url_retorno = ltrim($this->getUrl(),"/");
            if($url_retorno != 'login/login')
                $_SESSION[DB_DATABASE]['retorno'] = $url_retorno;
            $class = "App\\Controllers\\LoginController";
            $controller = new $class;
            $action = "index";
            $controller->$action();
        }
        else
        {
            $url = $url ? $url : "/index";
            $this->pag404 = true;
            array_walk($this->routes,function ($route) use ($url)
            {
                //verifica se o ultimo parametro é um numero - se for, é cadastro, edição ou paginas
                $arr_url = @explode("/",$url);
                $verif = @array_pop( $arr_url );
                if(is_numeric($verif))
                    $url = implode("/",$arr_url);
                if($url == $route['route'])
                {
                    //setar a rota principar para ativar o menu
                    $rotamenu = explode("/",$route['route']);
                    $_SESSION[DB_DATABASE]['rotaMenu'] = "/".$rotamenu[1];
                    $_SESSION[DB_DATABASE]['rotaUrl'] = $route['route'];

                    $this->pag404 = false;
                    $class = "App\\Controllers\\".ucfirst($route['controller']);
                    $controller = new $class;
                    $action = $route['action'];
                    $controller->$action();
                }
            });
            if($this->pag404)
            {
                $rotaMaster = explode("/",$url);
                $tamanho = count($rotaMaster);
                if($tamanho >= 3)//tem mais de um parametro na barra de endereço
                {
                    $rotaPrincipal = $rotaMaster[1];
                    array_walk($this->routes, function ($route) use ($rotaMaster) {
                        $rotaRaiz = explode("/",$route['route']);
                        if ($rotaRaiz[1] == $rotaMaster[1] && @$rotaRaiz[2] == @$rotaMaster[2]) {
                            //setar a rota principar para ativar o menu
                            $_SESSION[DB_DATABASE]['rotaMenu'] = "/".$rotaRaiz[1];
                            $_SESSION[DB_DATABASE]['rotaUrl'] = $route['route'];

                            $this->pag404 = false;
                            $class = "App\\Controllers\\" . ucfirst($route['controller']);
                            $controller = new $class;
                            $action = $route['action'];
                            $controller->$action();
                        }
                    });

                    if($this->pag404) {//ainda não achou - tenta setar a rota padrão
                        array_walk($this->routes, function ($route) use ($rotaPrincipal) {
                            $rotaRaiz = explode("/", $route['route']);
                            if ($rotaRaiz[1] == $rotaPrincipal) {
                                //setar a rota principar para ativar o menu
                                $_SESSION[DB_DATABASE]['rotaMenu'] = "/" . $rotaRaiz[1];
                                $_SESSION[DB_DATABASE]['rotaUrl'] = $route['route'];

                                $this->pag404 = false;
                                $class = "App\\Controllers\\" . ucfirst($route['controller']);
                                $controller = new $class;
                                $action = "padrao";
                                $controller->$action();
                            }
                        });
                    }
                }

                if($this->pag404) {
                    $class = "App\\Controllers\\NotFoundController";
                    $controller = new $class;
                    $action = "index";
                    $controller->$action();
                }
            }
        }

    }

    protected function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    public static function getUrl()
    {
        $base = @array_shift( @explode( "index.php",$_SERVER['SCRIPT_NAME'] ) );
        $url = str_replace( $base,"/", parse_url( $_SERVER['REQUEST_URI'],PHP_URL_PATH ) );
        $url = rtrim( $url, "/" );
        return $url;
    }

}
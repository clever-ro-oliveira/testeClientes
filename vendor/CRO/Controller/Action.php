<?php
namespace CRO\Controller;

use CRO\Init\Bootstrap;

abstract class Action
{
    protected $view;

    private $action;

    public function __construct()
    {
        $this->view = new \stdClass;
    }

    protected function render($action, $layout = true)
    {
        $this->action = $action;
        $layout === true ? include_once "App/Views/layout.phtml" : $this->content();
    }

    protected function content()
    {
        $current = get_class($this);
        $singleClassName = strtolower( str_replace("Controller", "",str_replace("App\\Controllers\\","",$current) ) );
        include_once "App/Views/".$singleClassName."/".$this->action.".phtml";
    }

}
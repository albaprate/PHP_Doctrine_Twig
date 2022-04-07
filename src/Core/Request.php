<?php

namespace App\Core;
use App\Core\Interfaces\IRequest;

class Request implements IRequest
{
    private $route;
    private $params;

    public function __construct()
    {
        $rawroute = $_SERVER["REQUEST_URI"]; //guarda la info de la petición
        $elementos_ruta = explode("/", $rawroute);
        $this->route = "/" . $elementos_ruta[1];
        $this->params = array_slice($elementos_ruta, 2);
        //var_dump($params);
        
    }

    /**
     * Get the value of route
     */ 
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Get the value of params
     */ 
    public function getParams()
    {
        return $this->params;
    }
}
<?php
namespace App\Core;

use App\Core\Interfaces\IRoutes;

class RouteCollection implements IRoutes
{
    private $routes;
    function __construct()
    {
        $this->routes = json_decode(file_get_contents(__DIR__."/../../config/Routes.json"), true);
        //abre el archivo Routes.json, lo lee como estring y devuelve su contenido en un array asociativo
    }

    /**
     * Get the value of routes
     */ 
    public function getRoutes()
    {
        return $this->routes;
    }
}

?>
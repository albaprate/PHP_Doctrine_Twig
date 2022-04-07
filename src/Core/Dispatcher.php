<?php
namespace App\Core;
use App\Core\Interfaces\IRequest;
use App\Core\Interfaces\IRoutes;

class Dispatcher
{
    private $routeList;
    private IRequest $currentRequest;
    public function __construct(IRoutes $routes, IRequest $request)
    {
        $this->routeList = $routes->getRoutes();
        //var_dump($this->routeList);
        $this->currentRequest = $request;
      //  var_dump($this->currentRequest);
        $this->dispatch();
    }

    public function dispatch(){      
        if(isset($this->routeList[$this->currentRequest->getRoute()])){
            $controllerClass = "App\\Controllers\\" . $this->routeList[$this->currentRequest->getRoute()]["controller"];                    
            $controller = new $controllerClass;
            $action = $this->routeList[$this->currentRequest->getRoute()]["action"];
            $controller->$action(...$this->currentRequest->getParams());
          
        } else {
            echo "ruta no existe";
        }
    }
}
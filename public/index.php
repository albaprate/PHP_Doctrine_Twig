<?php
require_once("../vendor/autoload.php");
 
use App\Core\RouteCollection;
use App\Core\Request;
use App\Core\Dispatcher;
use App\Core\EntityManager;

session_start();
$routes = new RouteCollection(); 
$request = new Request();
$dispatcher = new Dispatcher($routes, $request); 
?>
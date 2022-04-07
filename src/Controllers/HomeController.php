<?php

namespace App\Controllers;
use App\Core\AbstractController;

class HomeController extends AbstractController
{
    //home() usa el método render() de la clase que hereda para llamar a la plantilla TWIG y pasarle parámetros
    public function home()
    {
        $this->render("home.html", 
                [          
            "titulo" => "TWIG - ALBA" 
           
        ]);
    }
}
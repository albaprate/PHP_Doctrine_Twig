<?php

namespace App\Core;

//use App\Core\SessionManager;

abstract class AbstractController
{

    private $twig;
    //protected $sessionManager;

    public function __construct()
    {
        //$this->sessionManager = new SessionManager();

         //llamo a la platilla de TWIG
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new \Twig\Environment($loader);
         //declaro variable accesible de forma global, para mostrar en la plantilla el usuario que está navegando
        $this->twig->addGlobal('session', $_SESSION);

        
       // $this->sessionManager->setTemplateEngineAvailable($this->twig);
    }

    public function render($template, $params)
    {
        $template = $this->twig->load($template);
        echo $template->render($params);
    }
}

<?php

namespace App\Controllers;
use App\Core\AbstractController;

class LogoutController extends AbstractController{
    public function Logout()
    {
        //en el menú de navegación aparecerá la opción de login
        //destruyo la sesión
      if(session_destroy()){
          header("Location: /");      
      }

    }
}
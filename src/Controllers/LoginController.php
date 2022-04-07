<?php

namespace App\Controllers;
use App\Core\EntityManager;
use App\Core\AbstractController;
use App\Entity\{Agent,Events,Span};



class LoginController extends AbstractController
{
    // el usuario se loguea
    // cuando el usuario está logueado, se mostrarán más acciones en el menú de navegación, así como el logout
    public function login()
    {
        //recibo información del formulario por POST
        //si no tienen valor establezco la variable en NULL  
        $name = isset($_POST['name']) ? $_POST['name'] : NULL;
        $password = isset($_POST['password']) ? $_POST['password'] : NULL;     
       
        //compruebo su valor no está vacío
        if (empty($name) || empty($password)){
            $mensaje = "rellene ambos campos";
            
         //compruebo si tienen valor  
        }else if (isset($name) && isset($password)){           
            // 1 obtengo el entity manager
            // 2 obtengo el repositorio de la clase
            // 3 llamo al método del repositorio que realizará el login del agente

            $em = (new EntityManager())->get(); 
            $agentRepository = $em->getRepository(Agent::class); 
            $respuesta = $agentRepository->doLogin($name, $password);
    
            if ($respuesta){
                $mensaje = "Se ha logueado correctamente";
                header("Location: /");    
                $_SESSION["name"] = $name; // guardo el nombre en una variable de sesión   
            } else {
                $mensaje = "su usuario no está registrado";
            }
                                    
        }  

        // render() de la clase que hereda para llamar a la plantilla TWIG y pasarle parámetros
        $this->render("login.html", 
                [          
            "titulo" => "TWIG - ALBA",
            "mensaje" => $mensaje,
        ]);
    }
}


?>
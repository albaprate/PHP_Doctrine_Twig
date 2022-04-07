<?php

namespace App\Controllers;
use App\Core\EntityManager;
use App\Core\AbstractController;
use App\Entity\{Agent,Events};

class RegisterController extends AbstractController
{
    public function register()
    {
        //recibo información del formulario por POST
        //si no tienen valor establezco la variable en NULL      
        $name = isset($_POST['name']) ? $_POST['name'] : NULL;
        $password = isset($_POST['password']) ? $_POST['password'] : NULL;
        $faction = isset($_POST['faction']) ? $_POST['faction'] : NULL;    
   
        $mensaje = "";

        //compruebo que todos los campos se han rellenado
        if (empty($name) || empty($password) || empty($faction) ){
          $mensaje = "rellene todos los campos";
        
        //compruebo si tienen valor diferente a ""
        } else if (isset($name) && isset($password)){
            
            // 1 obtengo el entity manager
            // 2 obtengo el repositorio de la clase Agent
            // 3 llamo al método del repositorio que realizará el registro del agente
            $em = (new EntityManager())->get(); 
            $agentRepository = $em->getRepository(Agent::class); 
            $respuesta = $agentRepository->doRegister($name, $password, $faction);

            //si devuelve false
            if (!$respuesta){
                $mensaje = "el nombre está registrado, pruebe con otro";
            }else{
                //si devulve true (ha hecho el registro)
                header("Location: /dologin");    
            }

        }

       

        //el método render() de la clase que hereda para llamar a la plantilla TWIG y pasarle parámetros
        $this->render("register.html", 
            [                  
                "titulo" => "TWIG - ALBA",
                "mensaje" => $mensaje
           
            ]);
        
    }
}
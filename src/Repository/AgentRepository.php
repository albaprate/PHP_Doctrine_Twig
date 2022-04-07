<?php
namespace App\Repository;

use App\Entity\{Agent, Uploads};
use App\Core\EntityManager;
use Doctrine\ORM\EntityRepository;

class AgentRepository extends EntityRepository
{
     //registro del usuario
     public function doRegister($name, $password, $faction){

        //compruebo si el nombre ya está registrado por su nombre
        $agent = $this->findOneBy(['agentName'=>$name]);
        
        if ( $agent == NULL || empty($agent) ){
            // usuario no está registrado, no está en la bbdd;
            //registro del usuario
            // instancio clase, establezco valor a los atributos que se insertarán
            $agent = new Agent();
            $agent
                ->setAgentName($name)
                ->setPassword(hash('sha256', $password))
                ->setFaction($faction);
           
            //doctrine guarda los datos
            $this->getEntityManager()->persist($agent);
            //doctrine ejecuta la query
            $this->getEntityManager()->flush();
            return $agent->getIdAgent();
        } else {
            //el usuario ya está registrado
            return false;
        }
    }


    //login del usuario
    public function doLogin($name, $password)
    {
        $agent = $this->findOneBy(['agentName'=>$name]);
        if ( $agent == NULL || empty($agent) ){
            return false;
        } else {
            return true;            
        }
        
    }


    public function Profile(){
        //busca el usuario por el nombre y devuelve su registro
        $agent = $this->findOneBy(['agentName'=>$_SESSION["name"]]);
        return $agent;
    }

    public function AgentStatsEvents(){
        $agents = $this->findOneBy(['agentName'=>$_SESSION["name"]])->getStatsEvents();
        return $agents;
    }
}

 

?>
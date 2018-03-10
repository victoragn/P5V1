<?php
namespace Agnez\CoreBundle\ServiceGetSem;

use Agnez\CoreBundle\Repository\EdtHeureRepository;

class AgnezServiceGetSem{

    public function __construct(){

    }

    public function getSem($user,$numSem,$repo){//donne les heures de la semaine donnée d'un User donné
        $classes=$user->getClasses();
        $listeHeures=array();

        foreach ($classes as $classe){

            $listeHeureClasse=$repo->findBy(
                array('classe'=> $classe,
                'numSem'=> $numSem
            ));
            foreach ($listeHeureClasse as $heureClasse){
                $listeHeures[]=$heureClasse;
            }


        }
        return $listeHeures;
    }

}

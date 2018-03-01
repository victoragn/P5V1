<?php
namespace Agnez\CoreBundle\ServiceInitEdt;
use Agnez\CoreBundle\Entity\EdtHeure;
use DateTime;
use DatePeriod;
use DateInterval;

class AgnezServiceInitEdt{

    private $serviceDate;
    private $nombreSem;

    public function __construct($serviceDate,$nombreSem){
        $this->serviceDate=$serviceDate;
        $this->nombreSem=$nombreSem;
    }

    public function setNewHeures($user){
        $classes=$user->getClasses();
        $listeHeures=array();

        for($j=1;$j<6;$j++){
            for($i=1;$i<9;$i++){
                $nomClasse=$user->getHebdoEDT()['hebdoEdt'][$j.$i];
                $heureRentree=$this->serviceDate->getTimeByNumHeure($j*10+$i)->format('Y-m-d H:i:s');
                if($nomClasse!=0){
                    foreach ($classes as $classe){
                        if ($nomClasse==$classe->getName()){
                            $classeEnreg=$classe;
                        }
                    }
                    for ($k=0;$k<$this->nombreSem;$k++){
                        $tempHeure=new DateTime($heureRentree);

                        $edtHeure= new EdtHeure($this->serviceDate);
                        $edtHeure->setDateDebut($tempHeure->add(new DateInterval('P'. $k*7 .'D')));
                        $edtHeure->setClasse($classeEnreg);
                        $listeHeures[]=$edtHeure;
                    }

                }
            }
        }
        return $listeHeures;
    }

    public function setPlaces($user){
        $classes=$user->getClasses();
        foreach ($classes as $classe){
            $eleves=$classe->getEleves();
            $i=1;
            foreach ($eleves as $eleve){
                $eleve->setPlace($i);
                $i++;
            }

        }
    }


}

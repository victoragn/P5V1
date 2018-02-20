<?php
namespace Agnez\CoreBundle\ServiceDate;

use DateTime;
use DatePeriod;
use DateInterval;

class AgnezServiceDate{
    private $dateDepart;
    private $h11=28800;//8h
    private $h12=32400;//9h
    private $h13=36000;//10h
    private $h14=39600;//11h
    private $h15=50400;//14h
    private $h16=54000;//15h
    private $h17=57600;//16h
    private $h18=61200;//17h
    private $h21,$h22,$h23,$h24,$h25,$h26,$h27,$h28,$h31,$h32,$h33,$h34,$h35,$h36,$h37,$h38,$h41,$h42,$h43,$h44,$h45,$h46,$h47,$h48,$h51,$h52,$h53,$h54,$h55,$h56,$h57,$h58;


    public function __construct($dateDepart){
        $this->dateDepart = new \DateTime($dateDepart);
        for($j=2;$j<6;$j++){
            for($i=1;$i<9;$i++){
                $this->{'h'.$j.$i} = $this->{'h1'.$i} + ($j-1)*86400 ;
            }
        }
    }

    public function numSem($date){
        $interval= $date->diff($this->dateDepart);
        $numSem=floor($interval->days /7) + 1;
        return  $numSem;
    }

    public function numHeure($date){
        $date1= $this->dateDepart->format('U');
        $date2= $date->format('U');
        $interval= $date2 - $date1;
        $numSec= $interval % 604800;
        $result =0;

        for($j=2;$j<6;$j++){
            for($i=1;$i<9;$i++){
                $temp='h'.$j.$i;
                if ($numSec >= $this->{'h'.$j.$i}  &&  $numSec < $this->{'h'.$j.$i} + 3600){$result= $j.$i;}
            }
        }
        return $result;
    }

    public function getTimeByNumHeure($numHeure){
        $date=$this->dateDepart;
        for($j=1;$j<6;$j++){
            for($i=1;$i<9;$i++){
                if ($numHeure===$j*10+$i){$date->add(new DateInterval('PT'.$this->{'h'.$j.$i}.'S'));}
            }
        }
        return $date;
    }


}

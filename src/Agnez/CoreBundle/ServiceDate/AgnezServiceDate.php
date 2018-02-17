<?php
namespace Agnez\CoreBundle\ServiceDate;

class AgnezServiceDate{
    private $dateDepart;
    public function __construct($dateDepart){
        $this->dateDepart = new \DateTime($dateDepart);

    }

    public function numSem($date){
        $interval=$date->diff($this->dateDepart);
        $numSem=floor($interval->days /7) + 1;
        return  $numSem;
    }

    public function numHeure($date){
        $h1=8*3600;
        $h2=$h1+3600;
        $h3=$h2+3600;
        $h4=$h3+3600;
        $h5=$h4+10800;
        $h6=$h5+3600;
        $h7=$h6+3600;
        $h8=$h7+3600;

        $date1=$this->dateDepart->format('U');
        $date2=$date->format('U');
        $interval=$date2 - $date1;
        $numSec= $interval % 604800;
        if ($numSec>=$h1 && $numSec<$h1+3600){
            return 11;
        }elseif($numSec>=$h2 && $numSec<$h2+3600){
            return 12;
        }elseif($numSec>=$h3 && $numSec<$h3+3600){
            return 13;
        }elseif($numSec>=$h4 && $numSec<$h4+3600){
            return 14;
        }elseif($numSec>=$h5 && $numSec<$h5+3600){
            return 15;
        }elseif($numSec>=$h6 && $numSec<$h6+3600){
            return 16;
        }elseif($numSec>=$h7 && $numSec<$h7+3600){
            return 17;
        }elseif($numSec>=$h8 && $numSec<$h8+3600){
            return 18;

        }elseif($numSec>=$h1+86400 && $numSec<$h1+3600+86400){
            return 21;
        }elseif($numSec>=$h2+86400 && $numSec<$h2+3600+86400){
            return 22;
        }elseif($numSec>=$h3+86400 && $numSec<$h3+3600+86400){
            return 23;
        }elseif($numSec>=$h4+86400 && $numSec<$h4+3600+86400){
            return 24;
        }elseif($numSec>=$h5+86400 && $numSec<$h5+3600+86400){
            return 25;
        }elseif($numSec>=$h6+86400 && $numSec<$h6+3600+86400){
            return 26;
        }elseif($numSec>=$h7+86400 && $numSec<$h7+3600+86400){
            return 27;
        }elseif($numSec>=$h8+86400 && $numSec<$h8+3600+86400){
            return 28;

        }elseif($numSec>=$h1+172800 && $numSec<$h1+3600+172800){
            return 31;
        }elseif($numSec>=$h2+172800 && $numSec<$h2+3600+172800){
            return 32;
        }elseif($numSec>=$h3+172800 && $numSec<$h3+3600+172800){
            return 33;
        }elseif($numSec>=$h4+172800 && $numSec<$h4+3600+172800){
            return 34;
        }elseif($numSec>=$h5+172800 && $numSec<$h5+3600+172800){
            return 35;
        }elseif($numSec>=$h6+172800 && $numSec<$h6+3600+172800){
            return 36;
        }elseif($numSec>=$h7+172800 && $numSec<$h7+3600+172800){
            return 37;
        }elseif($numSec>=$h8+172800 && $numSec<$h8+3600+172800){
            return 38;

        }elseif($numSec>=$h1+259200 && $numSec<$h1+3600+259200){
            return 41;
        }elseif($numSec>=$h2+259200 && $numSec<$h2+3600+259200){
            return 42;
        }elseif($numSec>=$h3+259200 && $numSec<$h3+3600+259200){
            return 43;
        }elseif($numSec>=$h4+259200 && $numSec<$h4+3600+259200){
            return 44;
        }elseif($numSec>=$h5+259200 && $numSec<$h5+3600+259200){
            return 45;
        }elseif($numSec>=$h6+259200 && $numSec<$h6+3600+259200){
            return 46;
        }elseif($numSec>=$h7+259200 && $numSec<$h7+3600+259200){
            return 47;
        }elseif($numSec>=$h8+259200 && $numSec<$h8+3600+259200){
            return 48;

        }elseif($numSec>=$h1+345600 && $numSec<$h1+3600+345600){
            return 51;
        }elseif($numSec>=$h2+345600 && $numSec<$h2+3600+345600){
            return 52;
        }elseif($numSec>=$h3+345600 && $numSec<$h3+3600+345600){
            return 53;
        }elseif($numSec>=$h4+345600 && $numSec<$h4+3600+345600){
            return 54;
        }elseif($numSec>=$h5+345600 && $numSec<$h5+3600+345600){
            return 55;
        }elseif($numSec>=$h6+345600 && $numSec<$h6+3600+345600){
            return 56;
        }elseif($numSec>=$h7+345600 && $numSec<$h7+3600+345600){
            return 57;
        }elseif($numSec>=$h8+345600 && $numSec<$h8+3600+345600){
            return 58;

        }else{
            return 0;
        }
    }


}

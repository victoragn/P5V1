<?php

namespace Agnez\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * EdtHeure
 *
 * @ORM\Table(name="edt_heure")
 * @ORM\Entity(repositoryClass="Agnez\CoreBundle\Repository\EdtHeureRepository")
 */
class EdtHeure
{
    /**
     * @ORM\OneToMany(targetEntity="Agnez\CoreBundle\Entity\Event", mappedBy="edtHeure")
     */
    private $events;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    *@var datetime
    *@ORM\Column(type="datetime", name="dateDebut")
    */
    private $dateDebut;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct(){
        $this->events = new ArrayCollection();
    }

    public function addEvent(Event $event){
        $this->events[] = $event;
    }

    public function removeEvent(Event $event){
        $this->events->removeElement($event);
    }

    public function getApplications(){
        return $this->applications;
    }

}


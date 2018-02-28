<?php

namespace Agnez\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * EdtHeure
 *
 * @ORM\Table(name="agnez_edt_heure")
 * @ORM\Entity(repositoryClass="Agnez\CoreBundle\Repository\EdtHeureRepository")
 */
class EdtHeure
{
    /**
     * @ORM\OneToMany(targetEntity="Agnez\CoreBundle\Entity\Event", mappedBy="edtHeure")
     */
    private $events;

    /**
     * @ORM\ManyToOne(targetEntity="Agnez\CoreBundle\Entity\Classe", inversedBy="edtHeures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

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
    *@var int
    *@ORM\Column(type="integer", name="numHeure")
    */
    private $numHeure;

    /**
    *@var int
    *@ORM\Column(type="integer", name="numSem")
    */
    private $numSem;

    private $servicedate;

       public function __construct($servicedate){
        $this->events = new ArrayCollection();
        $this->servicedate = $servicedate;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return EdtHeure
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
        $servicedate = $this->servicedate;
        $this->numSem=$servicedate->numSem($dateDebut);
        $this->numHeure=$servicedate->numHeure($dateDebut);

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set classe
     *
     * @param \Agnez\CoreBundle\Entity\Classe $classe
     *
     * @return EdtHeure
     */
    public function setClasse(\Agnez\CoreBundle\Entity\Classe $classe)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \Agnez\CoreBundle\Entity\Classe
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set numHeure
     *
     * @param \int $numHeure
     *
     * @return EdtHeure
     */
    public function setNumHeure(int $numHeure)
    {
        $this->numHeure = $numHeure;

        return $this;
    }

    /**
     * Get numHeure
     *
     * @return \int
     */
    public function getNumHeure()
    {
        return $this->numHeure;
    }

    /**
     * Set numSem
     *
     * @param \int $numSem
     *
     * @return EdtHeure
     */
    public function setNumSem(int $numSem)
    {
        $this->numSem = $numSem;

        return $this;
    }

    /**
     * Get numSem
     *
     * @return \int
     */
    public function getNumSem()
    {
        return $this->numSem;
    }
}

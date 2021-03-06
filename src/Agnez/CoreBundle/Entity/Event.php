<?php

namespace Agnez\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="agnez_event")
 * @ORM\Entity(repositoryClass="Agnez\CoreBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\ManyToOne(targetEntity="Agnez\CoreBundle\Entity\Eleve")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eleve;

    /**
     * @ORM\ManyToOne(targetEntity="Agnez\CoreBundle\Entity\EdtHeure", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $edtHeure;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Event
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set eleve
     *
     * @param \Agnez\CoreBundle\Entity\Eleve $eleve
     *
     * @return Event
     */
    public function setEleve(\Agnez\CoreBundle\Entity\Eleve $eleve)
    {
        $this->eleve = $eleve;

        return $this;
    }

    /**
     * Get eleve
     *
     * @return \Agnez\CoreBundle\Entity\Eleve
     */
    public function getEleve()
    {
        return $this->eleve;
    }

    /**
     * Set edtHeure
     *
     * @param \Agnez\CoreBundle\Entity\EdtHeure $edtHeure
     *
     * @return Event
     */
    public function setEdtHeure(\Agnez\CoreBundle\Entity\EdtHeure $edtHeure)
    {
        $this->edtHeure = $edtHeure;

        return $this;
    }

    /**
     * Get edtHeure
     *
     * @return \Agnez\CoreBundle\Entity\EdtHeure
     */
    public function getEdtHeure()
    {
        return $this->edtHeure;
    }
}

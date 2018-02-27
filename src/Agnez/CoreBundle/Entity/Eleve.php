<?php

namespace Agnez\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eleve
 *
 * @ORM\Table(name="agnez_eleve")
 * @ORM\Entity(repositoryClass="Agnez\CoreBundle\Repository\EleveRepository")
 */
class Eleve
{
    /**
     * @ORM\ManyToOne(targetEntity="Agnez\CoreBundle\Entity\Classe", inversedBy="eleves")
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var array
     *
     * @ORM\Column(name="arrayPlaces", type="array", nullable=true)
     */
    private $arrayPlaces;

    /**
     * @var int
     *
     * @ORM\Column(name="place", type="integer")
     */
    private $place;



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
     * Set nom
     *
     * @param string $nom
     *
     * @return Eleve
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Eleve
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set arrayPlaces
     *
     * @param array $arrayPlaces
     *
     * @return Eleve
     */
    public function setArrayPlaces($arrayPlaces)
    {
        $this->arrayPlaces = $arrayPlaces;

        return $this;
    }

    /**
     * Get arrayPlaces
     *
     * @return array
     */
    public function getArrayPlaces()
    {
        return $this->arrayPlaces;
    }

    /**
     * Set classe
     *
     * @param \Agnez\CoreBundle\Entity\Classe $classe
     *
     * @return Eleve
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
     * Set place
     *
     * @param integer $place
     *
     * @return Eleve
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return integer
     */
    public function getPlace()
    {
        return $this->place;
    }
}

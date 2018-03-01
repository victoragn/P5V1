<?php

namespace Agnez\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe
 *
 * @ORM\Table(name="agnez_classe")
 * @ORM\Entity(repositoryClass="Agnez\CoreBundle\Repository\ClasseRepository")
 */
class Classe
{
    /**
     * @ORM\ManyToOne(targetEntity="Agnez\UserBundle\Entity\User", inversedBy="classes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Agnez\CoreBundle\Entity\EdtHeure", mappedBy="classe",cascade={"all"})
     */
    private $edtHeures;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Agnez\CoreBundle\Entity\Eleve", mappedBy="classe",cascade={"all"})
     */
    private $eleves;

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
     * Set name
     *
     * @param string $name
     *
     * @return Classe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set user
     *
     * @param \Agnez\UserBundle\Entity\User $user
     *
     * @return Classe
     */
    public function setUser(\Agnez\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Agnez\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eleves = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add eleve
     *
     * @param \Agnez\CoreBundle\Entity\Eleve $eleve
     *
     * @return Classe
     */
    public function addEleve(\Agnez\CoreBundle\Entity\Eleve $eleve)
    {
        $this->eleves[] = $eleve;
        $eleve->setClasse($this);

        return $this;
    }

    /**
     * Remove eleve
     *
     * @param \Agnez\CoreBundle\Entity\Eleve $eleve
     */
    public function removeEleve(\Agnez\CoreBundle\Entity\Eleve $eleve)
    {
        $this->eleves->removeElement($eleve);
    }

    /**
     * Get eleves
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEleves()
    {
        return $this->eleves;
    }

    /**
     * Add edtHeure
     *
     * @param \Agnez\CoreBundle\Entity\EdtHeure $edtHeure
     *
     * @return Classe
     */
    public function addEdtHeure(\Agnez\CoreBundle\Entity\EdtHeure $edtHeure)
    {
        $this->edtHeures[] = $edtHeure;

        return $this;
    }

    /**
     * Remove edtHeure
     *
     * @param \Agnez\CoreBundle\Entity\EdtHeure $edtHeure
     */
    public function removeEdtHeure(\Agnez\CoreBundle\Entity\EdtHeure $edtHeure)
    {
        $this->edtHeures->removeElement($edtHeure);
    }

    /**
     * Get edtHeures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEdtHeures()
    {
        return $this->edtHeures;
    }
}

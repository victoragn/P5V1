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
}

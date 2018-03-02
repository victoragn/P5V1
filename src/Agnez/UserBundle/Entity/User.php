<?php

namespace Agnez\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="agnez_user")
 * @ORM\Entity(repositoryClass="Agnez\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="initialized", type="integer")
     */
    private $initialized=0; /*vaut false tant que l'on a pas créé les edtHeures grace à hebdoEDT*/


    /**
     * @var array
     *
     * @ORM\Column(name="hebdoEDT", type="array", nullable=true)
     */
    private $hebdoEDT;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Agnez\CoreBundle\Entity\Classe", mappedBy="user",cascade={"all"})
     */
    private $classes;

    /**
     * Set hebdoEDT
     *
     * @param array $hebdoEDT
     *
     * @return User
     */
    public function setHebdoEDT($hebdoEDT)
    {
        $this->hebdoEDT = $hebdoEDT;

        return $this;
    }

    /**
     * Get hebdoEDT
     *
     * @return array
     */
    public function getHebdoEDT()
    {
        return $this->hebdoEDT;
    }

    /**
     * Add class
     *
     * @param \Agnez\CoreBundle\Entity\Classe $class
     *
     * @return User
     */
    public function addClass(\Agnez\CoreBundle\Entity\Classe $class)
    {
        $this->classes[] = $class;
        $class->setUser($this);

        return $this;
    }

    /**
     * Remove class
     *
     * @param \Agnez\CoreBundle\Entity\Classe $class
     */
    public function removeClass(\Agnez\CoreBundle\Entity\Classe $class)
    {
        $this->classes->removeElement($class);
    }

    /**
     * Get classes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Set initialized
     *
     * @param integer $initialized
     *
     * @return User
     */
    public function setInitialized($initialized)
    {
        $this->initialized = $initialized;

        return $this;
    }

    /**
     * Get initialized
     *
     * @return integer
     */
    public function getInitialized()
    {
        return $this->initialized;
    }
}

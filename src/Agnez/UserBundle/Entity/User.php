<?php

namespace Agnez\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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
     * @var boolean
     *
     * @ORM\Column(name="initialized", type="boolean", options={"default":false})
     */
    private $initialized; /*vaut false tant que l'on a pas créé les edtHeures grace à hebdoEDT*/


    /**
     * @var array
     *
     * @ORM\Column(name="hebdoEDT", type="array", nullable=true)
     */
    private $hebdoEDT;

}

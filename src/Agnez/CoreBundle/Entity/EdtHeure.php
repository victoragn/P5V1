<?php

namespace Agnez\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}


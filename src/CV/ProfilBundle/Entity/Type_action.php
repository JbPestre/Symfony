<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type_action
 *
 * @ORM\Table(name="type_action")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\Type_actionRepository")
 */
class Type_action
{
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
   * @ORM\OneToMany(targetEntity="CV\ProfilBundle\Entity\Actions", cascade={"persist"}, mappedBy="type")
   */
  private $actions;


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
     * @return Type_action
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
     * Constructor
     */
    public function __construct()
    {
        $this->actions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add action
     *
     * @param \CV\ProfilBundle\Entity\Actions $action
     *
     * @return Type_action
     */
    public function addAction(\CV\ProfilBundle\Entity\Actions $action)
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Remove action
     *
     * @param \CV\ProfilBundle\Entity\Actions $action
     */
    public function removeAction(\CV\ProfilBundle\Entity\Actions $action)
    {
        $this->actions->removeElement($action);
    }

    /**
     * Get actions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActions()
    {
        return $this->actions;
    }
}

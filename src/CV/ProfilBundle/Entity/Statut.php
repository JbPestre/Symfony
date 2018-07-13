<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statut
 *
 * @ORM\Table(name="statut")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\StatutRepository")
 */
class Statut
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
   * @ORM\OneToMany(targetEntity="CV\ProfilBundle\Entity\Profil", cascade={"persist"}, mappedBy="statut")
   */
  private $profil;

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
     * @return Statut
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
        $this->profil = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add profil
     *
     * @param \CV\ProfilBundle\Entity\Profil $profil
     *
     * @return Statut
     */
    public function addProfil(\CV\ProfilBundle\Entity\Profil $profil)
    {
        $this->profil[] = $profil;

        return $this;
    }

    /**
     * Remove profil
     *
     * @param \CV\ProfilBundle\Entity\Profil $profil
     */
    public function removeProfil(\CV\ProfilBundle\Entity\Profil $profil)
    {
        $this->profil->removeElement($profil);
    }

    /**
     * Get profil
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfil()
    {
        return $this->profil;
    }
}

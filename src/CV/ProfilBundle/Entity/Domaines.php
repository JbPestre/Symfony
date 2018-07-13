<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domaines
 *
 * @ORM\Table(name="domaines")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\DomainesRepository")
 */
class Domaines
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
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Profil", cascade={"persist"},mappedBy="Domaines")
   */
  private $profil;

           /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Interlocuteur", cascade={"persist"},mappedBy="Domaines")
   */
  private $interlocuteur;

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
     * @return Domaines
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
        $this->interlocuteur = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add profil
     *
     * @param \CV\ProfilBundle\Entity\Profil $profil
     *
     * @return Domaines
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

    /**
     * Add interlocuteur
     *
     * @param \CV\ProfilBundle\Entity\Interlocuteur $interlocuteur
     *
     * @return Domaines
     */
    public function addInterlocuteur(\CV\ProfilBundle\Entity\Interlocuteur $interlocuteur)
    {
        $this->interlocuteur[] = $interlocuteur;

        return $this;
    }

    /**
     * Remove interlocuteur
     *
     * @param \CV\ProfilBundle\Entity\Interlocuteur $interlocuteur
     */
    public function removeInterlocuteur(\CV\ProfilBundle\Entity\Interlocuteur $interlocuteur)
    {
        $this->interlocuteur->removeElement($interlocuteur);
    }

    /**
     * Get interlocuteur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterlocuteur()
    {
        return $this->interlocuteur;
    }
}

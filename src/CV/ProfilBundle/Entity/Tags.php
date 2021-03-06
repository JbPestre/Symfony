<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\TagsRepository")
 */
class Tags
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
     * @ORM\Column(name="intitule", type="string", length=255)
     */
    public $intitule;

    /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Profil", cascade={"persist"}, mappedBy="tags")
   */
  private $profil;

    /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Client", cascade={"persist"}, mappedBy="tags")
   */
  private $client;

    /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Competences", cascade={"persist"}, mappedBy="tags")
   */
  private $competences;

     /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Experiences", cascade={"persist"}, mappedBy="tags")
   */
  private $experiences;

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
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Tags
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
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
     * @return Tags
     */
    public function addProfil(\CV\ProfilBundle\Entity\Profil $profil)
    {
        $this->profil[] = $profil;

        $profil->setTags($this);

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
     * Add competence
     *
     * @param \CV\ProfilBundle\Entity\Competences $competence
     *
     * @return Tags
     */
    public function addCompetence(\CV\ProfilBundle\Entity\Competences $competence)
    {
        $this->competences[] = $competence;

        return $this;
    }

    /**
     * Remove competence
     *
     * @param \CV\ProfilBundle\Entity\Competences $competence
     */
    public function removeCompetence(\CV\ProfilBundle\Entity\Competences $competence)
    {
        $this->competences->removeElement($competence);
    }

    /**
     * Get competences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * Add client
     *
     * @param \CV\ProfilBundle\Entity\Client $client
     *
     * @return Tags
     */
    public function addClient(\CV\ProfilBundle\Entity\Client $client)
    {
        $this->client[] = $client;

        return $this;
    }

    /**
     * Remove client
     *
     * @param \CV\ProfilBundle\Entity\Client $client
     */
    public function removeClient(\CV\ProfilBundle\Entity\Client $client)
    {
        $this->client->removeElement($client);
    }

    /**
     * Get client
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Add experience
     *
     * @param \CV\ProfilBundle\Entity\Experiences $experience
     *
     * @return Tags
     */
    public function addExperience(\CV\ProfilBundle\Entity\Experiences $experience)
    {
        $this->experiences[] = $experience;

        return $this;
    }

    /**
     * Remove experience
     *
     * @param \CV\ProfilBundle\Entity\Experiences $experience
     */
    public function removeExperience(\CV\ProfilBundle\Entity\Experiences $experience)
    {
        $this->experiences->removeElement($experience);
    }

    /**
     * Get experiences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExperiences()
    {
        return $this->experiences;
    }
}

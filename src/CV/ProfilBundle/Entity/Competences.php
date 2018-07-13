<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Competences
 *
 * @ORM\Table(name="competences")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\CompetencesRepository")
 */
class Competences
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
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptif", type="text")
     */
    private $descriptif;


    /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Tags", cascade={"persist"},inversedBy="competences")
   */
    public $tags;




 public function __clone() {
    if ($this->id) {


        $tags = $this->getTags();
        $this->tags = new ArrayCollection();
        if(count($tags) > 0){
            foreach ($tags as $tag) {
                $cloneTag = clone $tag;
                $this->tags->add($cloneTag);
            }
        } 

    }
}
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
     * @return Competences
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
     * Set descriptif
     *
     * @param string $descriptif
     *
     * @return Competences
     */
    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * Get descriptif
     *
     * @return string
     */
    public function getDescriptif()
    {
        return $this->descriptif;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tag
     *
     * @param \CV\ProfilBundle\Entity\Tags $tag
     *
     * @return Competences
     */
    public function addTag(\CV\ProfilBundle\Entity\Tags $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \CV\ProfilBundle\Entity\Tags $tag
     */
    public function removeTag(\CV\ProfilBundle\Entity\Tags $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set tags
     *
     * @param \CV\ProfilBundle\Entity\Tags $tags
     *
     * @return Competences
     */
    public function setTags(\CV\ProfilBundle\Entity\Tags $tags = null)
    {
        $this->tags = $tags;

        return $this;
    }
}

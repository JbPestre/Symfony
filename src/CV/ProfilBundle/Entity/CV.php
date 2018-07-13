<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CV
 *
 * @ORM\Table(name="cv")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\CVRepository")
 */
class CV
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
     * @ORM\Column(name="descriptif", type="string", length=2550)
     */
    private $descriptif;

     /**
   * @ORM\ManyToOne(targetEntity="CV\ProfilBundle\Entity\Profil", cascade={"persist"},inversedBy="cv")
   */
    private $profil;

       /**
   * @ORM\ManyToOne(targetEntity="CV\UserBundle\Entity\RI", cascade={"persist"})
   */
    private $Ri;

    /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Experiences", cascade={"persist"})
   */
    private $experiences;

    /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Langues", cascade={"persist"})
   */
    private $langues;

     /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Formations", cascade={"persist"})
   */
    private $formations;

      /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Competences", cascade={"persist"})
   */
    private $competences;

     /**
   * @ORM\ManyToOne(targetEntity="CV\ProfilBundle\Entity\Client", cascade={"persist"})
   */
    private $client;



     /**
     * @ORM\Column(name="date_crea", type="datetime",nullable=true)
     */
    private $dateCrea;

    /**
     * @var string
     *
     * @ORM\Column(name="bloc_libre1", type="text",nullable=true)
     */
    private $bloc_libre1;

    /**
     * @var string
     *
     * @ORM\Column(name="bloc_libre2", type="text",nullable=true)
     */
    private $bloc_libre2;


    /**
     * @var pos_forma
     *
     * @ORM\Column(name="pos_forma", type="integer",nullable=true)
     */
    private $pos_forma;


    /**
     * @var pos_comp
     *
     * @ORM\Column(name="pos_comp", type="integer",nullable=true)
     */
    private $pos_comp;


    /**
     * @var pos_exp
     *
     * @ORM\Column(name="pos_exp", type="integer",nullable=true)
     */
    private $pos_exp;


    /**
     * @var pos_lang
     *
     * @ORM\Column(name="pos_lang", type="integer",nullable=true)
     */
    private $pos_lang;

    /**
     * @var pos_libre1
     *
     * @ORM\Column(name="pos_libre1", type="integer",nullable=true)
     */
    private $pos_libre1;


    /**
     * @var pos_libre2
     *
     * @ORM\Column(name="pos_libre2", type="integer",nullable=true)
     */
    private $pos_libre2;



    /**
     * @var block_forma
     *
     * @ORM\Column(name="block_forma", type="string",nullable=true)
     */
    private $block_forma;


    /**
     * @var block_comp
     *
     * @ORM\Column(name="block_comp", type="string",nullable=true)
     */
    private $block_comp;


    /**
     * @var block_libre1
     *
     * @ORM\Column(name="block_libre1", type="string",nullable=true)
     */
    private $block_libre1;


    /**
     * @var block_libre2
     *
     * @ORM\Column(name="block_libre2", type="string",nullable=true)
     */
    private $block_libre2;


    /**
     * @var block_exp
     *
     * @ORM\Column(name="block_exp", type="string",nullable=true)
     */
    private $block_exp;


    /**
     * @var block_lang
     *
     * @ORM\Column(name="block_lang", type="string",nullable=true)
     */
    private $block_lang;


 public function __clone() {
    if ($this->id) {


        $competences = $this->getCompetences();
        $this->competences = new ArrayCollection();
        if(count($competences) > 0){
            foreach ($competences as $competence) {
                $cloneCompetence = clone $competence;
                $this->competences->add($cloneCompetence);
            }
        } 


          $formations = $this->getFormations();
        $this->formations = new ArrayCollection();
        if(count($formations) > 0){
            foreach ($formations as $formation) {
                $cloneFormation = clone $formation;
                $this->formations->add($cloneFormation);
            }
        } 


          $experiences = $this->getExperiences();
        $this->experiences = new ArrayCollection();
        if(count($experiences) > 0){
            foreach ($experiences as $experience) {
                $cloneExperience= clone $experience;
                $this->experiences->add($cloneExperience);
            }
        } 


          $langues = $this->getLangues();
        $this->langues = new ArrayCollection();
        if(count($langues) > 0){
            foreach ($langues as $langue) {
                $cloneLangue = clone $langue;
                $this->langues->add($cloneLangue);
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
     * @return CV
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
     * @return CV
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


    public function setProfil(Profil $profil)
    {
        $this->profil = $profil;

        return $this;
    }

    
    public function getProfil()
    {
        return $this->profil;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCrea = new \Datetime();
        $this->experiences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add experience
     *
     * @param \CV\ProfilBundle\Entity\Experiences $experience
     *
     * @return CV
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

    /**
     * Add client
     *
     * @param \CV\ProfilBundle\Entity\Client $client
     *
     * @return CV
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
     * Set client
     *
     * @param \CV\ProfilBundle\Entity\Client $client
     *
     * @return CV
     */
    public function setClient(\CV\ProfilBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Set dateCrea
     *
     * @param \DateTime $dateCrea
     *
     * @return CV
     */
    public function setDateCrea($dateCrea)
    {
        $this->dateCrea = $dateCrea;

        return $this;
    }

    /**
     * Get dateCrea
     *
     * @return \DateTime
     */
    public function getDateCrea()
    {
        return $this->dateCrea;
    }

    /**
     * Set ri
     *
     * @param \CV\UserBundle\Entity\RI $ri
     *
     * @return CV
     */
    public function setRi(\CV\UserBundle\Entity\RI $ri = null)
    {
        $this->Ri = $ri;

        return $this;
    }

    /**
     * Get ri
     *
     * @return \CV\UserBundle\Entity\RI
     */
    public function getRi()
    {
        return $this->Ri;
    }

    /**
     * Add langue
     *
     * @param \CV\ProfilBundle\Entity\Langues $langue
     *
     * @return CV
     */
    public function addLangue(\CV\ProfilBundle\Entity\Langues $langue)
    {
        $this->langues[] = $langue;

        return $this;
    }

    /**
     * Remove langue
     *
     * @param \CV\ProfilBundle\Entity\Langues $langue
     */
    public function removeLangue(\CV\ProfilBundle\Entity\Langues $langue)
    {
        $this->langues->removeElement($langue);
    }

    /**
     * Get langues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLangues()
    {
        return $this->langues;
    }

    /**
     * Add formation
     *
     * @param \CV\ProfilBundle\Entity\Formations $formation
     *
     * @return CV
     */
    public function addFormation(\CV\ProfilBundle\Entity\Formations $formation)
    {
        $this->formations[] = $formation;

        return $this;
    }

    /**
     * Remove formation
     *
     * @param \CV\ProfilBundle\Entity\Formations $formation
     */
    public function removeFormation(\CV\ProfilBundle\Entity\Formations $formation)
    {
        $this->formations->removeElement($formation);
    }

    /**
     * Get formations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormations()
    {
        return $this->formations;
    }

    /**
     * Add competence
     *
     * @param \CV\ProfilBundle\Entity\Competences $competence
     *
     * @return CV
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
     * Set posForma
     *
     * @param integer $posForma
     *
     * @return CV
     */
    public function setPosForma($posForma)
    {
        $this->pos_forma = $posForma;

        return $this;
    }

    /**
     * Get posForma
     *
     * @return integer
     */
    public function getPosForma()
    {
        return $this->pos_forma;
    }

    /**
     * Set posComp
     *
     * @param integer $posComp
     *
     * @return CV
     */
    public function setPosComp($posComp)
    {
        $this->pos_comp = $posComp;

        return $this;
    }

    /**
     * Get posComp
     *
     * @return integer
     */
    public function getPosComp()
    {
        return $this->pos_comp;
    }

    /**
     * Set posExp
     *
     * @param integer $posExp
     *
     * @return CV
     */
    public function setPosExp($posExp)
    {
        $this->pos_exp = $posExp;

        return $this;
    }

    /**
     * Get posExp
     *
     * @return integer
     */
    public function getPosExp()
    {
        return $this->pos_exp;
    }

    /**
     * Set posLang
     *
     * @param integer $posLang
     *
     * @return CV
     */
    public function setPosLang($posLang)
    {
        $this->pos_lang = $posLang;

        return $this;
    }

    /**
     * Get posLang
     *
     * @return integer
     */
    public function getPosLang()
    {
        return $this->pos_lang;
    }

    /**
     * Set blockForma
     *
     * @param string $blockForma
     *
     * @return CV
     */
    public function setBlockForma($blockForma)
    {
        $this->block_forma = $blockForma;

        return $this;
    }

    /**
     * Get blockForma
     *
     * @return string
     */
    public function getBlockForma()
    {
        return $this->block_forma;
    }

    /**
     * Set blockComp
     *
     * @param string $blockComp
     *
     * @return CV
     */
    public function setBlockComp($blockComp)
    {
        $this->block_comp = $blockComp;

        return $this;
    }

    /**
     * Get blockComp
     *
     * @return string
     */
    public function getBlockComp()
    {
        return $this->block_comp;
    }

    /**
     * Set blockExp
     *
     * @param string $blockExp
     *
     * @return CV
     */
    public function setBlockExp($blockExp)
    {
        $this->block_exp = $blockExp;

        return $this;
    }

    /**
     * Get blockExp
     *
     * @return string
     */
    public function getBlockExp()
    {
        return $this->block_exp;
    }

    /**
     * Set blockLang
     *
     * @param string $blockLang
     *
     * @return CV
     */
    public function setBlockLang($blockLang)
    {
        $this->block_lang = $blockLang;

        return $this;
    }

    /**
     * Get blockLang
     *
     * @return string
     */
    public function getBlockLang()
    {
        return $this->block_lang;
    }

    /**
     * Set blocLibre1
     *
     * @param string $blocLibre1
     *
     * @return CV
     */
    public function setBlocLibre1($blocLibre1)
    {
        $this->bloc_libre1 = $blocLibre1;

        return $this;
    }

    /**
     * Get blocLibre1
     *
     * @return string
     */
    public function getBlocLibre1()
    {
        return $this->bloc_libre1;
    }

    /**
     * Set blocLibre2
     *
     * @param string $blocLibre2
     *
     * @return CV
     */
    public function setBlocLibre2($blocLibre2)
    {
        $this->bloc_libre2 = $blocLibre2;

        return $this;
    }

    /**
     * Get blocLibre2
     *
     * @return string
     */
    public function getBlocLibre2()
    {
        return $this->bloc_libre2;
    }

    /**
     * Set posLibre1
     *
     * @param integer $posLibre1
     *
     * @return CV
     */
    public function setPosLibre1($posLibre1)
    {
        $this->pos_libre1 = $posLibre1;

        return $this;
    }

    /**
     * Get posLibre1
     *
     * @return integer
     */
    public function getPosLibre1()
    {
        return $this->pos_libre1;
    }

    /**
     * Set posLibre2
     *
     * @param integer $posLibre2
     *
     * @return CV
     */
    public function setPosLibre2($posLibre2)
    {
        $this->pos_libre2 = $posLibre2;

        return $this;
    }

    /**
     * Get posLibre2
     *
     * @return integer
     */
    public function getPosLibre2()
    {
        return $this->pos_libre2;
    }

    /**
     * Set blockLibre1
     *
     * @param string $blockLibre1
     *
     * @return CV
     */
    public function setBlockLibre1($blockLibre1)
    {
        $this->block_libre1 = $blockLibre1;

        return $this;
    }

    /**
     * Get blockLibre1
     *
     * @return string
     */
    public function getBlockLibre1()
    {
        return $this->block_libre1;
    }

    /**
     * Set blockLibre2
     *
     * @param string $blockLibre2
     *
     * @return CV
     */
    public function setBlockLibre2($blockLibre2)
    {
        $this->block_libre2 = $blockLibre2;

        return $this;
    }

    /**
     * Get blockLibre2
     *
     * @return string
     */
    public function getBlockLibre2()
    {
        return $this->block_libre2;
    }
}

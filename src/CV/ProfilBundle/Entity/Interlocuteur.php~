<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interlocuteur
 *
 * @ORM\Table(name="interlocuteur")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\InterlocuteurRepository")
 */
class Interlocuteur
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
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="poste", type="string", length=255)
     */
    private $poste;

    /**
     * @var string
     *
     * @ORM\Column(name="Tel_1", type="string", length=255, nullable=true)
     */
    private $tel1;

    /**
     * @var string
     *
     * @ORM\Column(name="Tel_2", type="string", length=255, nullable=true)
     */
    private $tel2;

    /**
     * @var string
     *
     * @ORM\Column(name="Tel_3", type="string", length=255, nullable=true)
     */
    private $tel3;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     */
    private $email;

         /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Domaines", cascade={"persist"},inversedBy="interlocuteur")
   */
  private $Domaines;

    /**
   * @ORM\ManyToOne(targetEntity="CV\ProfilBundle\Entity\Client", cascade={"persist"},inversedBy="contacts")
   */
  private $client;

    /**
   * @ORM\ManyToOne(targetEntity="CV\UserBundle\Entity\RI", cascade={"persist"})
   */
  private $ri; 

       /**
     * @ORM\Column(name="date_crea", type="datetime")
     */
    private $dateCrea;


       /**
   * @ORM\OneToMany(targetEntity="CV\ProfilBundle\Entity\Actions", cascade={"persist"}, mappedBy="interlocuteur")
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
     * @return Interlocuteur
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Interlocuteur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set poste
     *
     * @param string $poste
     *
     * @return Interlocuteur
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set tel1
     *
     * @param string $tel1
     *
     * @return Interlocuteur
     */
    public function setTel1($tel1)
    {
        $this->tel1 = $tel1;

        return $this;
    }

    /**
     * Get tel1
     *
     * @return string
     */
    public function getTel1()
    {
        return $this->tel1;
    }

    /**
     * Set tel2
     *
     * @param string $tel2
     *
     * @return Interlocuteur
     */
    public function setTel2($tel2)
    {
        $this->tel2 = $tel2;

        return $this;
    }

    /**
     * Get tel2
     *
     * @return string
     */
    public function getTel2()
    {
        return $this->tel2;
    }

    /**
     * Set tel3
     *
     * @param string $tel3
     *
     * @return Interlocuteur
     */
    public function setTel3($tel3)
    {
        $this->tel3 = $tel3;

        return $this;
    }

    /**
     * Get tel3
     *
     * @return string
     */
    public function getTel3()
    {
        return $this->tel3;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Interlocuteur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Domaines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateCrea = new \Datetime();
    }

    /**
     * Add domaine
     *
     * @param \CV\ProfilBundle\Entity\Domaines $domaine
     *
     * @return Interlocuteur
     */
    public function addDomaine(\CV\ProfilBundle\Entity\Domaines $domaine)
    {
        $this->Domaines[] = $domaine;

        return $this;
    }

    /**
     * Remove domaine
     *
     * @param \CV\ProfilBundle\Entity\Domaines $domaine
     */
    public function removeDomaine(\CV\ProfilBundle\Entity\Domaines $domaine)
    {
        $this->Domaines->removeElement($domaine);
    }

    /**
     * Get domaines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDomaines()
    {
        return $this->Domaines;
    }

    /**
     * Set client
     *
     * @param \CV\ProfilBundle\Entity\Client $client
     *
     * @return Interlocuteur
     */
    public function setClient(\CV\ProfilBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \CV\ProfilBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set ri
     *
     * @param \CV\UserBundle\Entity\RI $ri
     *
     * @return Interlocuteur
     */
    public function setRi(\CV\UserBundle\Entity\RI $ri = null)
    {
        $this->ri = $ri;

        return $this;
    }

    /**
     * Get ri
     *
     * @return \CV\UserBundle\Entity\RI
     */
    public function getRi()
    {
        return $this->ri;
    }

    /**
     * Set dateCrea
     *
     * @param \DateTime $dateCrea
     *
     * @return Interlocuteur
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
     * Add action
     *
     * @param \CV\ProfilBundle\Entity\Actions $action
     *
     * @return Interlocuteur
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

<?php

namespace CV\ProfilBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\ProfilRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"nom", "prenom"}, message="Nom et prénom déjà existant !")
 */
class Profil
{


    /**
 * @ORM\PreUpdate
 */
    public function updateDate()
  {
    $this->setUpdatedAt(new \Datetime());
  }


    
   /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string")
     */
    private $prenom;

    /**
     * @ORM\Column(name="intitule", type="string")
     */
    private $intitule;

      /**
     * @ORM\Column(name="date_crea", type="datetime")
     */
    private $dateCrea;


    /**
     * @ORM\Column(name="adresse", type="string")
     */
    private $adresse;

    /**
     * @ORM\Column(name="code_postal", type="string")
     */
    private $code_postal;

      /**
   * @ORM\OneToMany(targetEntity="CV\ProfilBundle\Entity\Commentaires", cascade={"persist"}, mappedBy="profil")
   */
  private $commentaires;

    /**
     * @ORM\Column(name="ville", type="string")
     */
    private $ville;

    /**
     * @ORM\Column(name="telephone", type="string")
     */
    private $telephone;

     /**
     * @ORM\Column(name="mail", type="string")
     */
    private $mail;

      /**
     * @ORM\Column(name="civilite", type="string")
     */
    private $civilite;

      /**
   * @ORM\ManyToOne(targetEntity="CV\ProfilBundle\Entity\Statut", cascade={"persist"},inversedBy="profil")
   */
  private $statut;

/**
 * @ORM\Column(name="updated_at", type="datetime", nullable=true)
 */
    private $updatedAt;


  /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Fichiers", cascade={"persist"})
   */
  private $fichiers;

    /**
   * @ORM\Column(name="published", type="boolean")
   */
  private $published = true;


 /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Url", cascade={"persist"})
   */
    private $urls;

     /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Domaines", cascade={"persist"},inversedBy="profil")
   */
  private $Domaines;

   /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Tags", cascade={"persist"},inversedBy="profil")
   */
  private $tags;

    /**
   * @ORM\OneToMany(targetEntity="CV\ProfilBundle\Entity\CV", cascade={"persist"},mappedBy="profil")
   */
    private $cv;

      /**
     * Constructor
     */
  public function __construct()
  {
    $this->dateCrea = new \Datetime();
      $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
  }

   /**
   * @ORM\ManyToOne(targetEntity="CV\UserBundle\Entity\RI", cascade={"persist"})
   */
  private $ri;

  
  
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
     * Set dateCrea
     *
     * @param \DateTime $dateCrea
     *
     * @return Profil
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Profil
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
     * @return Profil
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
     * Set type
     *
     * @param string $type
     *
     * @return Profil
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Profil
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    

public function setFichiers(Fichiers $fichiers = null)
      {
        $this->fichiers = $fichiers;
      }

    public function getFichiers()
      {
        return $this->fichiers;
      }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Profil
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Profil
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }


    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Profil
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Profil
     */
    public function setCodePostal($codePostal)
    {
        $this->code_postal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->code_postal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Profil
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Profil
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Profil
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     *
     * @return Profil
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }



    /**
     * Add url
     *
     * @param \CV\ProfilBundle\Entity\Url $url
     *
     * @return Profil
     */
    public function addUrl(\CV\ProfilBundle\Entity\Url $url)
    {
        $this->urls[] = $url;

        return $this;
    }

    /**
     * Remove url
     *
     * @param \CV\ProfilBundle\Entity\Url $url
     */
    public function removeUrl(\CV\ProfilBundle\Entity\Url $url)
    {
        $this->urls->removeElement($url);
    }

    /**
     * Get urls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Set ri
     *
     * @param \CV\UserBundle\Entity\RI $ri
     *
     * @return Profil
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
     * Add fichier
     *
     * @param \CV\ProfilBundle\Entity\Fichiers $fichier
     *
     * @return Profil
     */
    public function addFichier(\CV\ProfilBundle\Entity\Fichiers $fichier)
    {
        $this->fichiers[] = $fichier;

        return $this;
    }

    /**
     * Remove fichier
     *
     * @param \CV\ProfilBundle\Entity\Fichiers $fichier
     */
    public function removeFichier(\CV\ProfilBundle\Entity\Fichiers $fichier)
    {
        $this->fichiers->removeElement($fichier);
    }

    /**
     * Add domaine
     *
     * @param \CV\ProfilBundle\Entity\Domaines $domaine
     *
     * @return Profil
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
     * Add tag
     *
     * @param \CV\ProfilBundle\Entity\Tags $tag
     *
     * @return Profil
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
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Profil
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
     * Add commentaire
     *
     * @param \CV\ProfilBundle\Entity\Commentaires $commentaire
     *
     * @return Profil
     */
    public function addCommentaire(\CV\ProfilBundle\Entity\Commentaires $commentaire)
    {
        $this->commentaires[] = $commentaire;

        $commentaire->setProfil($this);

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \CV\ProfilBundle\Entity\Commentaires $commentaire
     */
    public function removeCommentaire(\CV\ProfilBundle\Entity\Commentaires $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add cv
     *
     * @param \CV\ProfilBundle\Entity\CV $cv
     *
     * @return Profil
     */
    public function addCv(\CV\ProfilBundle\Entity\CV $cv)
    {
        $this->cv[] = $cv;

        return $this;
    }

    /**
     * Remove cv
     *
     * @param \CV\ProfilBundle\Entity\CV $cv
     */
    public function removeCv(\CV\ProfilBundle\Entity\CV $cv)
    {
        $this->cv->removeElement($cv);
    }

    /**
     * Get cv
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCv()
    {
        return $this->cv;
    }
}

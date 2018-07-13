<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\ClientRepository")
 * @UniqueEntity(fields="nom", message="Nom du client déjà existant !")
 */
class Client
{

   /**
 * @ORM\PreUpdate
 */
    public function updateDate()
  {
    $this->setUpdatedAt(new \Datetime());
  }


     public function __construct()
  {
    $this->dateCrea = new \Datetime();
    $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;



     /**
   * @ORM\OneToMany(targetEntity="CV\ProfilBundle\Entity\Commentaires", cascade={"persist"}, mappedBy="client")
   */
  private $commentaires;

       /**
   * @ORM\OneToMany(targetEntity="CV\ProfilBundle\Entity\Interlocuteur", cascade={"persist"}, mappedBy="client")
   */
  private $contacts;

    /**
     * @ORM\Column(name="date_crea", type="datetime")
     */
    private $dateCrea;

  /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Fichiers", cascade={"persist"})
   */
  private $fichiers;

   /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Url", cascade={"persist"})
   */
    private $urls;

    /**
       * @ORM\ManyToOne(targetEntity="CV\UserBundle\Entity\RI", cascade={"persist"})
       */
      private $ri;

       /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Tags", cascade={"persist"},inversedBy="client")
   */
  private $tags;
  
  /**
 * @ORM\Column(name="updated_at", type="datetime", nullable=true)
 */
    private $updatedAt;


          /**
   * @ORM\ManyToOne(targetEntity="CV\ProfilBundle\Entity\Pays", cascade={"persist"},inversedBy="client")
   */
  private $pays;

            /**
   * @ORM\ManyToOne(targetEntity="CV\ProfilBundle\Entity\Type_client", cascade={"persist"},inversedBy="client")
   */
  private $type;

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
     * @return Client
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
     * Set type
     *
     * @param string $type
     *
     * @return Client
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
     * Set pays
     *
     * @param string $pays
     *
     * @return Client
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return Client
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires
     *
     * @return string
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set dateCrea
     *
     * @param \DateTime $dateCrea
     *
     * @return Client
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
     * Set fichiers
     *
     * @param \CV\ProfilBundle\Entity\Fichiers $fichiers
     *
     * @return Client
     */
    public function setFichiers(\CV\ProfilBundle\Entity\Fichiers $fichiers = null)
    {
        $this->fichiers = $fichiers;

        return $this;
    }

    /**
     * Get fichiers
     *
     * @return \CV\ProfilBundle\Entity\Fichiers
     */
    public function getFichiers()
    {
        return $this->fichiers;
    }

    /**
     * Set ri
     *
     * @param \CV\UserBundle\Entity\RI $ri
     *
     * @return Client
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
     * @return Client
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
     * Add url
     *
     * @param \CV\ProfilBundle\Entity\Url $url
     *
     * @return Client
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
     * Add commentaire
     *
     * @param \CV\ProfilBundle\Entity\Commentaires $commentaire
     *
     * @return Client
     */
    public function addCommentaire(\CV\ProfilBundle\Entity\Commentaires $commentaire)
    {
        $this->commentaires[] = $commentaire;

         $commentaire->setClient($this);

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
     * Add tag
     *
     * @param \CV\ProfilBundle\Entity\Tags $tag
     *
     * @return Client
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Client
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
     * Add contact
     *
     * @param \CV\ProfilBundle\Entity\Interlocuteur $contact
     *
     * @return Client
     */
    public function addContact(\CV\ProfilBundle\Entity\Interlocuteur $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \CV\ProfilBundle\Entity\Interlocuteur $contact
     */
    public function removeContact(\CV\ProfilBundle\Entity\Interlocuteur $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add pay
     *
     * @param \CV\ProfilBundle\Entity\Pays $pay
     *
     * @return Client
     */
    public function addPay(\CV\ProfilBundle\Entity\Pays $pay)
    {
        $this->pays[] = $pay;

        return $this;
    }

    /**
     * Remove pay
     *
     * @param \CV\ProfilBundle\Entity\Pays $pay
     */
    public function removePay(\CV\ProfilBundle\Entity\Pays $pay)
    {
        $this->pays->removeElement($pay);
    }
}

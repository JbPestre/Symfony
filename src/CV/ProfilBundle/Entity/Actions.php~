<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actions
 *
 * @ORM\Table(name="actions")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\ActionsRepository")
 */
class Actions
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
   * @ORM\ManyToOne(targetEntity="CV\ProfilBundle\Entity\Type_action", cascade={"persist"},inversedBy="actions")
   */
  private $type;

     /**
   * @ORM\Column(name="valide", type="boolean")
   */
    private $valide = false;


    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="text",nullable=true)
     */
    private $commentaires;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_crea", type="datetime")
     */
    private $dateCrea;

     /**
     * @var \Date
     *
     * @ORM\Column(name="date_action", type="date")
     */
    private $dateAction;

     /**
   * @ORM\ManyToMany(targetEntity="CV\ProfilBundle\Entity\Fichiers", cascade={"persist"})
   */
  private $fichiers;

    /**
   * @ORM\ManyToOne(targetEntity="CV\UserBundle\Entity\RI", cascade={"persist"})
   */
  private $ri;

    /**
   * @ORM\ManyToOne(targetEntity="CV\ProfilBundle\Entity\Interlocuteur", cascade={"persist"},inversedBy="actions")
   */
  private $interlocuteur;


     public function __construct()
  {
    $this->dateCrea = new \Datetime();
    $this->dateAction = new \Datetime();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Actions
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
     * @return Actions
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
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return Actions
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
     * @return Actions
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
     * Set valide
     *
     * @param boolean $valide
     *
     * @return Actions
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return boolean
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Add fichier
     *
     * @param \CV\ProfilBundle\Entity\Fichiers $fichier
     *
     * @return Actions
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
     * Get fichiers
     *
     * @return \Doctrine\Common\Collections\Collection
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
     * @return Actions
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
     * Set interlocuteur
     *
     * @param \CV\ProfilBundle\Entity\Interlocuteur $interlocuteur
     *
     * @return Actions
     */
    public function setInterlocuteur(\CV\ProfilBundle\Entity\Interlocuteur $interlocuteur = null)
    {
        $this->interlocuteur = $interlocuteur;

        return $this;
    }

    /**
     * Get interlocuteur
     *
     * @return \CV\ProfilBundle\Entity\Interlocuteur
     */
    public function getInterlocuteur()
    {
        return $this->interlocuteur;
    }

    /**
     * Set dateAction
     *
     * @param \DateTime $dateAction
     *
     * @return Actions
     */
    public function setDateAction($dateAction)
    {
        $this->dateAction = $dateAction;

        return $this;
    }

    /**
     * Get dateAction
     *
     * @return \DateTime
     */
    public function getDateAction()
    {
        return $this->dateAction;
    }
}

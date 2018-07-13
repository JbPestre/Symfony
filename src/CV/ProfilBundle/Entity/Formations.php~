<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formations
 *
 * @ORM\Table(name="formations")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\FormationsRepository")
 */
class Formations
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
     * @ORM\Column(name="nom_formation", type="string", length=255)
     */
    private $nomFormation;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptif", type="text")
     */
    private $descriptif;

    /**
     * @var string
     *
     * @ORM\Column(name="annee_debut", type="string", length=255)
     */
    private $anneeDebut;

    /**
     * @var string
     *
     * @ORM\Column(name="annee_fin", type="string", length=255, nullable = true)
     */
    private $anneeFin;


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
     * Set nomFormation
     *
     * @param string $nomFormation
     *
     * @return Formations
     */
    public function setNomFormation($nomFormation)
    {
        $this->nomFormation = $nomFormation;

        return $this;
    }

    /**
     * Get nomFormation
     *
     * @return string
     */
    public function getNomFormation()
    {
        return $this->nomFormation;
    }

    /**
     * Set descriptif
     *
     * @param string $descriptif
     *
     * @return Formations
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
     * Set anneeDebut
     *
     * @param string $anneeDebut
     *
     * @return Formations
     */
    public function setAnneeDebut($anneeDebut)
    {
        $this->anneeDebut = $anneeDebut;

        return $this;
    }

    /**
     * Get anneeDebut
     *
     * @return string
     */
    public function getAnneeDebut()
    {
        return $this->anneeDebut;
    }

    /**
     * Set anneeFin
     *
     * @param string $anneeFin
     *
     * @return Formations
     */
    public function setAnneeFin($anneeFin)
    {
        $this->anneeFin = $anneeFin;

        return $this;
    }

    /**
     * Get anneeFin
     *
     * @return string
     */
    public function getAnneeFin()
    {
        return $this->anneeFin;
    }
}

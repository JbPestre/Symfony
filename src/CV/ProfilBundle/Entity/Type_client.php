<?php

namespace CV\ProfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type_client
 *
 * @ORM\Table(name="type_client")
 * @ORM\Entity(repositoryClass="CV\ProfilBundle\Repository\Type_clientRepository")
 */
class Type_client
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
   * @ORM\OneToMany(targetEntity="CV\ProfilBundle\Entity\Client", cascade={"persist"}, mappedBy="type")
   */
  private $client;

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
     * @return Type_client
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
        $this->client = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add client
     *
     * @param \CV\ProfilBundle\Entity\Client $client
     *
     * @return Type_client
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
}

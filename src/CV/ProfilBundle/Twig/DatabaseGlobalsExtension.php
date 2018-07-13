<?php

namespace CV\ProfilBundle\Twig;

use Doctrine\ORM\EntityManager;

class DatabaseGlobalsExtension extends \Twig_Extension
{

   protected $em;

   public function __construct(EntityManager $em)
   {
      $this->em = $em;
   }

   public function getGlobals()
   {  
      $query = $this->em->createQueryBuilder();

      $query
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0 and p.dateAction <= :now')
            ->setParameter('now', new \DateTime('now + 7 day'));

      $notif = $query->getQuery()->getSingleScalarResult();

      return array (
              "notif" => $notif,
      );
   }

   public function getName()
   {
      return "CVProfilBundle:DatabaseGlobalsExtension";
   }

}
<?php

// src/cv/ProfilBundle/Controller/ClientController.php

namespace CV\ProfilBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !
use CV\ProfilBundle\Entity\Client;
use CV\ProfilBundle\Entity\Fichiers;
use CV\ProfilBundle\Entity\Commentaires;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use CV\ProfilBundle\Form\Client\ClientType;
use CV\ProfilBundle\Form\Client\ClientEditType;
use CV\ProfilBundle\Form\Profil\FichierType;
use CV\ProfilBundle\Form\Profil\CommentaireType;
use CV\ProfilBundle\Form\Profil\UrlType;

class ClientController extends Controller
{

public function indexAction()
  {
    // ...
 $em = $this->getDoctrine()->getManager();

    // Notre liste d'annonce en dur
     $listClients = $em
      ->getRepository('CVProfilBundle:Client')
       ->findall(
      array('nom' => 'desc'))   
    ;

       $listDomaines = $em
      ->getRepository('CVProfilBundle:Domaines')
      ->findall();

       $listTypes = $em
      ->getRepository('CVProfilBundle:Type_client')
      ->findall();

$query = $em->createQueryBuilder();
       $query
            ->select('count(p.id) as clients')
            ->from('CVProfilBundle:Client', 'p');

        $nbclients = $query->getQuery()->getSingleScalarResult();

$query5 = $em->createQueryBuilder();
         $query5
            ->select('DISTINCT p')
            ->from('CVUserBundle:RI', 'p')
            ->groupBy('p.nom');

$listRi = $query5->getQuery()->getResult();

    $selec = 'Entreprise';

    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('CVProfilBundle:Client:liste.html.twig', array(
      'listClients' => $listClients,
      'listDomaines' => $listDomaines,
      'listTypes' => $listTypes,
      'listRi' => $listRi,
      'nbclients' => $nbclients,
      'selec' => $selec,
    ));

  }

  public function indexcontactAction()
  {
    // ...
 $em = $this->getDoctrine()->getManager();

    // Notre liste d'annonce en dur
     $listClients = $em
      ->getRepository('CVProfilBundle:Interlocuteur')
       ->findall(
      array('dateCrea' => 'desc'))   
    ;

           $listTypes = $em
      ->getRepository('CVProfilBundle:Type_client')
      ->findall();

       $listDomaines = $em
      ->getRepository('CVProfilBundle:Domaines')
      ->findall();

$query = $em->createQueryBuilder();
       $query
            ->select('count(p.id) as contacts')
            ->from('CVProfilBundle:Interlocuteur', 'p');

        $nbcontacts = $query->getQuery()->getSingleScalarResult();

$query5 = $em->createQueryBuilder();
         $query5
            ->select('DISTINCT p')
            ->from('CVUserBundle:RI', 'p')
            ->groupBy('p.nom');

$listRi = $query5->getQuery()->getResult();

    $selec = 'Interlocuteur';

    $all = true;

    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('CVProfilBundle:Client:liste.html.twig', array(
      'listClients' => $listClients,
      'listDomaines' => $listDomaines,
      'listTypes' => $listTypes,
        'listRi' => $listRi,
      'nbcontacts' => $nbcontacts,
      'selec' => $selec,
      'all' => $all,
    ));

  }

  public function addAction(Request $request)
  {
    $Client = new Client();
    $form   = $this->get('form.factory')->create(ClientType::class, $Client);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


      $em = $this->getDoctrine()->getManager();
      $user = $this->getUser();
      $user->getId();
      $Client->setRI($user);

       $var = $form->get('commentaires')->getData();

     foreach ($var as $var2) {
      $var2->setRI($user);
       $var2->setClient($Client);
     }
      $em->persist($Client);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Client bien enregistré.');

      return $this->redirectToRoute('cv_profil_viewclient', array('id' => $Client->getId()));
    }

    return $this->render('CVProfilBundle:Client:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }



  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $Client = $em->getRepository('CVProfilBundle:Client')->find($id);

    if (null === $Client) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    $form = $this->get('form.factory')->create(ClientEditType::class, $Client);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      $Client->setUpdatedAt(new \Datetime());
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('cv_profil_viewclient', array('id' => $Client->getId()));
    }

    return $this->render('CVProfilBundle:Client:edit.html.twig', array(
      'Client' => $Client,
      'form'   => $form->createView(),
    ));
  }

public function viewAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $Client = $em->getRepository('CVProfilBundle:Client')->find($id);

    $listCv = $em
      ->getRepository('CVProfilBundle:CV')
      ->findBy(
      array('client' => $id),
      array('dateCrea' => 'desc')                     
    );
    $listContact = $em
      ->getRepository('CVProfilBundle:Interlocuteur')
      ->findBy(
      array('client' => $id),
      array('dateCrea' => 'desc')                     
    );

        $listCom = $em
      ->getRepository('CVProfilBundle:Commentaires')
      ->findBy(
      array('client' => $id),
      array('dateCrea' => 'desc')                     
    );

    $Com = new Commentaires();
    $form   = $this->get('form.factory')->create(CommentaireType::class, $Com);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


      $em2 = $this->getDoctrine()->getManager();
      $user = $this->getUser();
      $user->getId();
      $Com->setRI($user);
      $Com->setClient($Client);
      $Client->setUpdatedAt(new \Datetime());
      $em2->persist($Com);
      $em2->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien enregistré.');

      return $this->redirectToRoute('cv_profil_viewclient', array('id' => $Client->getId()));
    }

    if (null === $Client) {
      throw new NotFoundHttpException("Le client d'id ".$id." n'existe pas.");
    }


  $query2 = $em->createQueryBuilder();
      $query1 = $em->createQueryBuilder();
  

       $query1
            ->select('i.id')
            ->from('CVProfilBundle:Tags', 'p')
            ->innerJoin('p.client','j')
            ->innerJoin('p.experiences','i')
            ->where('j.id = :id')
            ->groupBy('i.id')
            ->setParameter('id', $id);

        $listExp = $query1->getQuery()->getResult();

    $query2
            ->select('p.intitule','count(p.intitule) as cou','(e.id) as idexp')
            ->from('CVProfilBundle:Tags', 'p')
            ->innerJoin('p.client','j')
            ->leftJoin('p.experiences','e')
            ->where('j.id = :id')
            ->groupBy('p.intitule')
            ->orderBy('cou', 'DESC')
            ->setParameter('id', $id);

        $listTags = $query2->getQuery()->getResult();

 $listActions = array();

foreach ($listContact as $contact) {
 $listActions = $em
      ->getRepository('CVProfilBundle:Actions')
      ->findBy(
      array('interlocuteur' => $contact),
      array('dateAction' => 'ASC')                     
    );
}

$valide = $request->request->get('valide');
$nonvalide = $request->request->get('nonvalide');
$avenir = $request->request->get('avenir');
$validation = $request->request->get('validation');
$newdatevalidation = $request->request->get('newdatevalidation');
$newdate = new \DateTime($request->request->get('newdate'));
$scroll = "nonpresent";

    if(isset($validation)){
$scroll = "present";
 $actionselec = $em
      ->getRepository('CVProfilBundle:Actions')
      ->find($validation);

$actionselec->setValide(true);
$em->flush();


}


if(isset($newdatevalidation)){

$scroll = "present";
 $actionselec1 = $em
      ->getRepository('CVProfilBundle:Actions')
      ->find($newdatevalidation);

$actionselec1->setDateAction($newdate);
$actionselec1->setValide(false);
$em->flush($actionselec1);


}

    $isavenir = "non";
$isnonvalide = "oui";
$isvalide = "non";


if(isset($nonvalide)){

$isavenir = "non";
$isnonvalide = "oui";
$isvalide = "non";
$scroll = "present";

$queryy = $em->createQueryBuilder();


     $queryy
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p');

    $id20 = 0;

            foreach ($listContact as $contact) {
              $contact20 = $contact->getId();
  $queryy
            ->where('p.valide = 0 and p.interlocuteur = '.$contact20);
            $id20++;
          }

  $listActions = $queryy->getQuery()->getResult();

} else if(isset($avenir)){

$isavenir = "oui";
$isnonvalide = "non";
$isvalide = "non";
$scroll = "present";

$queryy = $em->createQueryBuilder();


  $queryy
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p');
                $id30 = 0;
            foreach ($listContact as $contact) {
              $contact30 = $contact->getId();
  $queryy           
            ->where('p.valide = 0 and p.dateAction >= :now and p.interlocuteur = '.$contact30)
            ->setParameter('now', new \DateTime('now'));

            $id30++;
}

  $listActions = $queryy->getQuery()->getResult();

} else if(isset($valide)){

$isavenir = "non";
$isnonvalide = "non";
$isvalide = "oui";
$scroll = "present";

$queryy = $em->createQueryBuilder();

  $queryy
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p');

             $id40 = 0;
            foreach ($listContact as $contact) {
              $contact40 = $contact->getId();
  $queryy
            ->where('p.valide > 0 and p.interlocuteur = '.$contact40);
               $id40++;
          }

$listActions = $queryy->getQuery()->getResult();

}


$query20 = $em->createQueryBuilder();
$query30 = $em->createQueryBuilder();
$query40 = $em->createQueryBuilder();

if(empty($listContact))
{

  $countnonvalide = array(0);
  $countavenir = array(0);
  $countvalide = array(0);

}else{
  $query20
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p');

    $id20 = 0;

            foreach ($listContact as $contact) {
              $contact20 = $contact->getId();
  $query20
            ->where('p.valide = 0 and p.interlocuteur = '.$contact20);
            $id20++;
          }

  $query30
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p');
                $id30 = 0;
            foreach ($listContact as $contact) {
              $contact30 = $contact->getId();
  $query30           
            ->where('p.valide = 0 and p.dateAction >= :now and p.interlocuteur = '.$contact30)
            ->setParameter('now', new \DateTime('now'));

            $id30++;
}

  $query40
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p');

             $id40 = 0;
            foreach ($listContact as $contact) {
              $contact40 = $contact->getId();
  $query40
            ->where('p.valide > 0 and p.interlocuteur = '.$contact40);
               $id40++;
          }


  $countnonvalide = $query20->getQuery()->getOneOrNullResult();
  $countavenir = $query30->getQuery()->getOneOrNullResult();
  $countvalide = $query40->getQuery()->getOneOrNullResult();
}



    return $this->render('CVProfilBundle:Client:view.html.twig', array(
      'Client' => $Client,
      'scroll' => $scroll,
      'listExp' => $listExp,
      'listTags' => $listTags,
      'listContact' => $listContact,
      'listActions' => $listActions,
       'listCv' => $listCv,
      'listCom' => $listCom,
      'isavenir' => $isavenir,
    'isvalide' => $isvalide,
    'isnonvalide' => $isnonvalide,
    'countnonvalide' => $countnonvalide,
    'countavenir' => $countavenir,
    'countvalide' => $countvalide,
      'form'   => $form->createView(),
    ));
  }

public function deleteAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $Client = $em->getRepository('CVProfilBundle:Client')->find($id);

    $coms = $em->getRepository('CVProfilBundle:Commentaires')->findBy(
  array('client' => $id));

    if (null === $Client) {
      throw new NotFoundHttpException("Le client d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($Client);
      foreach ($coms as $com) {
         $em->remove($com);
      }
    
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "Le client a bien été supprimé.");

      return $this->redirectToRoute('cv_profil_homeclient');
    }
    
    return $this->render('CVProfilBundle:Client:delete.html.twig', array(
      'Client' => $Client,
      'form'   => $form->createView(),
    ));
  }

public function searchAction(Request $request)
  { 

    $em = $this->getDoctrine()->getManager();

        $listDomaines = $em
      ->getRepository('CVProfilBundle:Domaines')
      ->findall();

             $listTypes = $em
      ->getRepository('CVProfilBundle:Type_client')
      ->findall();

$query5 = $em->createQueryBuilder();
         $query5
            ->select('DISTINCT p')
            ->from('CVUserBundle:RI', 'p')
            ->groupBy('p.nom');

$listRi = $query5->getQuery()->getResult();

    if ($request->getMethod() == "POST") {

         $search = $request->request->get('search');
        $datas = explode(" / ", $search); 

        $post2 = $request->request->get('type');
        $post3 = $request->request->get('domaine');
        $post4 = $request->request->get('ri');
        $date_debut = $request->request->get('date_debut');
        $date_fin = $request->request->get('date_fin');
  
        $selec = $request->request->get('optradio');


} elseif ($request->getMethod() == "GET"){

        $post2 = array();
        $post3 = array();
        $post4 = array();

        if($request->query->get('typesearch')){

        $selec = $request->query->get('typesearch');
        $globalsearch = $request->query->get('globalsearch');
        $datas = explode(" / ", $globalsearch);
        }else{

        $datas = array();

          }

        $date_debut = "2018-05-01";
        $date_fin = date("Y-m-d"); 


      }

      $query = $em->createQueryBuilder();

        if ($selec == 'Entreprise'){

        $query
            ->select('p')
            ->from('CVProfilBundle:Client', 'p');

        $i4 = 0;
        foreach ($post4 as $data4) {

          if ($i4 > 0){

          $query
                  ->orWhere('IDENTITY(p.ri) LIKE :data4'.$i4)
                  ->setParameter('data4'.$i4, '%'.$data4.'%');

                   $i4++; 

          }else{

           $query
                  ->andWhere('IDENTITY(p.ri) LIKE :data4'.$i4)
                  ->setParameter('data4'.$i4, '%'.$data4.'%');  

          $i4++; 

          } 

        }

        $i2 = 0;
        foreach ($post2 as $data2) {

            if ($i2 > 0){

          $query
                ->orWhere('IDENTITY(p.type) LIKE :data2'.$i2)
                ->setParameter('data2'.$i2, '%'.$data2.'%');
           $i2++;

           }else{

              $query
                ->andWhere('IDENTITY(p.type) LIKE :data2'.$i2)
                ->setParameter('data2'.$i2, '%'.$data2.'%');

            $i2++; 

          } 
        }
            
        $i = 0;
        foreach ($datas as $data) {
            $query
                ->andWhere('p.nom LIKE :data'.$i)
                ->setParameter('data'.$i, '%'.$data.'%');
           $i++;
        }
        
        $idate = 0;
        $query
                ->andWhere('p.dateCrea >= :datad'.$idate.' AND p.dateCrea <= :datab'.$idate)
                ->setParameter('datad'.$idate, $date_debut)
                ->setParameter('datab'.$idate, $date_fin);


        $listClients = $query->getQuery()->getResult();    


        $qb = $em->createQueryBuilder();

    $qb->select('COUNT(DISTINCT p.id)')
        ->from('CVProfilBundle:Client', 'p' );

         $id4 = 0;

        foreach ($post4 as $data4) {

          if ($id4 > 0){

          $qb
                  ->orWhere('IDENTITY(p.ri) LIKE :data4'.$id4)
                  ->setParameter('data4'.$id4, '%'.$data4.'%');

          }else{

           $qb
                  ->andWhere('IDENTITY(p.ri) LIKE :data4'.$id4)
                  ->setParameter('data4'.$id4, '%'.$data4.'%');  

          $id4++; 

          } 

        }

        $id2 = 0;
        foreach ($post2 as $data2) {

            if ($id2 > 0){

          $qb
                ->orWhere('IDENTITY(p.type) LIKE :data2'.$id2)
                ->setParameter('data2'.$id2, '%'.$data2.'%');
           $i2++;

           }else{

              $qb
                ->andWhere('IDENTITY(p.type) LIKE :data2'.$id2)
                ->setParameter('data2'.$id2, '%'.$data2.'%');

            $id2++; 

          } 
        }

        $i = 0;
        foreach ($datas as $data) {
            $qb
                ->andWhere('p.nom LIKE :data'.$i)
                ->setParameter('data'.$i, '%'.$data.'%');
           $i++;
        }
        
        $idate = 0;
        $qb
                ->andWhere('p.dateCrea >= :datad'.$idate.' AND p.dateCrea <= :datab'.$idate)
                ->setParameter('datad'.$idate, $date_debut)
                ->setParameter('datab'.$idate, $date_fin);

        $count = $qb->getQuery()->getSingleScalarResult();

        $post = $request->request->get('search');

////////////////////////////////////////

} else {

///////////////////////////////////////////

 $query
            ->select('p')
            ->from('CVProfilBundle:Interlocuteur', 'p')
            ->leftJoin('p.Domaines','j');

        $i4 = 0;
        foreach ($post4 as $data4) {

          if ($i4 > 0){

          $query
                  ->orWhere('IDENTITY(p.ri) LIKE :data4'.$i4)
                  ->setParameter('data4'.$i4, '%'.$data4.'%');

                   $i4++; 

          }else{

           $query
                  ->andWhere('IDENTITY(p.ri) LIKE :data4'.$i4)
                  ->setParameter('data4'.$i4, '%'.$data4.'%');  

          $i4++; 

          } 

        }
        

        $i3 = 0;
        foreach ($post3 as $data3) {

            if ($i3 > 0){

          $query
                ->orWhere('j.nom LIKE :data3'.$i3)
                ->setParameter('data3'.$i3, '%'.$data3.'%');
           $i3++;

           }else{

              $query
                ->andWhere('j.nom LIKE :data3'.$i3)
                ->setParameter('data3'.$i3, '%'.$data3.'%');

            $i3++; 

          } 
        }


        $id = 0;
        foreach ($datas as $data) {
            $query
                ->andWhere('p.nom LIKE :data'.$id.' OR p.prenom LIKE :data'.$id.' OR p.poste LIKE :data'.$id)
                ->setParameter('data'.$id, '%'.$data.'%');
           $id++;
        }
        
        $idate = 0;
        $query
                ->andWhere('p.dateCrea >= :datad'.$idate.' AND p.dateCrea <= :datab'.$idate)
                ->setParameter('datad'.$idate, $date_debut)
                ->setParameter('datab'.$idate, $date_fin);


        $listClients = $query->getQuery()->getResult();    


        $qb = $em->createQueryBuilder();

    $qb->select('COUNT(DISTINCT p.id)')
        ->from('CVProfilBundle:Interlocuteur', 'p' )
        ->leftJoin('p.Domaines','j');

         $id4 = 0;

        foreach ($post4 as $data4) {

          if ($id4 > 0){

          $qb
                  ->orWhere('IDENTITY(p.ri) LIKE :data4'.$id4)
                  ->setParameter('data4'.$id4, '%'.$data4.'%');

          }else{

           $qb
                  ->andWhere('IDENTITY(p.ri) LIKE :data4'.$id4)
                  ->setParameter('data4'.$id4, '%'.$data4.'%');  

          $id4++; 

          } 

        }

      $i3 = 0;
        foreach ($post3 as $data3) {

            if ($i3 > 0){

          $qb
                ->orWhere('j.nom LIKE :data3'.$i3)
                ->setParameter('data3'.$i3, '%'.$data3.'%');
           $i3++;

           }else{

              $qb
                ->andWhere('j.nom LIKE :data3'.$i3)
                ->setParameter('data3'.$i3, '%'.$data3.'%');

            $i3++; 

          } 
        }

        $id = 0;
        foreach ($datas as $data) {
            $qb
                ->andWhere('p.nom LIKE :data'.$id.' OR p.prenom LIKE :data'.$id.' OR p.poste LIKE :data'.$id)
                ->setParameter('data'.$id, '%'.$data.'%');
           $id++;
        }
        
        $idate = 0;
        $qb
                ->andWhere('p.dateCrea >= :datad'.$idate.' AND p.dateCrea <= :datab'.$idate)
                ->setParameter('datad'.$idate, $date_debut)
                ->setParameter('datab'.$idate, $date_fin);

        $count = $qb->getQuery()->getSingleScalarResult();

        $post = $request->request->get('search');

  }

  


    return $this->render('CVProfilBundle:Client:liste.html.twig', array(
        'listClients' => $listClients,
        'listDomaines' => $listDomaines,
        'listTypes' => $listTypes,
          'listRi' => $listRi,
        'count' => $count,
        'post' => $post,
        'post2' => $post2,
        'post3' => $post3,
        'post4' => $post4,
        'selec' => $selec,
        'date_debut' => $date_debut,
        'date_fin' => $date_fin,
        'datas' => $datas,
    ));

  }


public function deletecomAction(Request $request, $id, $id_profil)
  {
    $em = $this->getDoctrine()->getManager();

    $Client = $em->getRepository('CVProfilBundle:Client')->find($id_profil);
    $Com = $em->getRepository('CVProfilBundle:Commentaires')->find($id);

    if (null === $Com) {
      throw new NotFoundHttpException("Le commentaire d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($Com);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "Le commentaire a bien été supprimé.");

      return $this->redirectToRoute('cv_profil_view', array('id' => $id_profil));
    }
    
    return $this->render('CVProfilBundle:Profil:deletecom.html.twig', array(
      'Client'  => $Client,
      'Com' => $Com,
      'form'   => $form->createView(),
    ));
  }


public function editcomAction(Request $request, $id, $id_profil)
  {
   
    $em = $this->getDoctrine()->getManager();

    $Client = $em->getRepository('CVProfilBundle:Client')->find($id_profil);
    $Com = $em->getRepository('CVProfilBundle:Commentaires')->find($id);

     $listCv = $em
      ->getRepository('CVProfilBundle:CV')
      ->findBy(
      array('profil' => $id_profil),
      array('dateCrea' => 'desc')                     
    );

         $listCom = $em
      ->getRepository('CVProfilBundle:Commentaires')
      ->findBy(
      array('profil' => $id_profil),
      array('dateCrea' => 'desc')                     
    );

    $form = $this->get('form.factory')->create(CommentaireEditType::class, $Com);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $em->persist($Com);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien modifié.');

      return $this->redirectToRoute('cv_profil_viewclient', array('id' => $Client->getId()));
    }

    return $this->render('CVProfilBundle:Profil:editcom.html.twig', array(
      'Client' => $Client,
      'Com' => $Com,
      'form'   => $form->createView(),
    ));
  }


  public function downloadAction(Request $request, $filename)
  {
    $search = $request->request->get('download');
    $path = $this->get('kernel')->getRootDir(). "/../web/uploads/img/";
    $content = file_get_contents($path.$filename);

    $response = new Response();

    //set headers
    $response->headers->set('Content-Type', 'mime/type');
    $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

    $response->setContent($content);
    return $response;
  }
}
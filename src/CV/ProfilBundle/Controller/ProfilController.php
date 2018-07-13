<?php

// src/cv/ProfilBundle/Controller/ProfilController.php

namespace CV\ProfilBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CV\ProfilBundle\Entity\Url;
use CV\ProfilBundle\Entity\Profil;
use CV\ProfilBundle\Entity\Fichiers;
use CV\ProfilBundle\Entity\CV;
use CV\ProfilBundle\Entity\Tags;
use CV\ProfilBundle\Entity\Experiences;
use CV\ProfilBundle\Entity\Commentaires;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use CV\ProfilBundle\Form\Profil\ProfilType;
use CV\ProfilBundle\Form\Profil\ProfilEditType;
use CV\ProfilBundle\Form\Profil\FichierType;
use CV\ProfilBundle\Form\CV\ExperiencesType;
use CV\ProfilBundle\Form\CV\CVType;
use CV\ProfilBundle\Form\Profil\UrlsType;
use CV\ProfilBundle\Form\Profil\CommentaireType;
use CV\ProfilBundle\Form\Profil\CommentaireEditType;
use CV\ProfilBundle\Form\Profil\DomaineType;

class ProfilController extends Controller
{



public function listeAction()
  {
    // ...
 $em = $this->getDoctrine()->getManager();

    // Notre liste d'annonce en dur
     $listProfils = $em
      ->getRepository('CVProfilBundle:Profil')
      ->findall(
      array('dateCrea' => 'desc')                     
    );

       $listDomaines = $em
      ->getRepository('CVProfilBundle:Domaines')
      ->findall();

       $listStatut = $em
      ->getRepository('CVProfilBundle:Statut')
      ->findall();

 $query = $em->createQueryBuilder();

   $query
            ->select('DISTINCT p')
            ->from('CVProfilBundle:Tags', 'p')
            ->groupBy('p.intitule');

        $listTags = $query->getQuery()->getResult();


   $query2 = $em->createQueryBuilder();
 
   $query2
            ->select('DISTINCT p')
            ->from('CVProfilBundle:Competences', 'p')
            ->groupBy('p.intitule');

        $listComp = $query2->getQuery()->getResult();

$query3 = $em->createQueryBuilder();

   $query3
            ->select('DISTINCT p')
            ->from('CVProfilBundle:Langues', 'p')
            ->groupBy('p.langage');

        $listLang = $query3->getQuery()->getResult();

$query4 = $em->createQueryBuilder();

   $query4
            ->select('count(p.id) as profils')
            ->from('CVProfilBundle:profil', 'p');

        $nbprofils = $query4->getQuery()->getSingleScalarResult();

$query5 = $em->createQueryBuilder();
         $query5
            ->select('DISTINCT p')
            ->from('CVUserBundle:RI', 'p')
            ->groupBy('p.nom');

$listRi = $query5->getQuery()->getResult();
        
    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('CVProfilBundle:Profil:liste.html.twig', array(
      'listProfils' => $listProfils,
      'listTags' => $listTags,
       'listDomaines' => $listDomaines,
       'listStatut' => $listStatut,
       'listRi' => $listRi,
      'nbprofils' => $nbprofils,
      'listComp' => $listComp,
      'listLang' => $listLang,
    ));

  }



public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $Profil = $em->getRepository('CVProfilBundle:Profil')->find($id);

    if (null === $Profil) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    $form = $this->get('form.factory')->create(ProfilEditType::class, $Profil);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

    $commentairemodif = new Commentaires();

      $em2 = $this->getDoctrine()->getManager();
      $user = $this->getUser();
      $user->getId();
      $var2 = $user->getPrenom(); 

      $commentairemodif->setRI($user);
      $commentairemodif->setProfil($Profil);
      $commentairemodif->setChamp('Modifications effectuées par '.$var2.' le '.date("d/m/Y"));
      $commentairemodif->setFromModif(true);
      $em2->persist($commentairemodif);
      $em2->flush();




      $em->persist($Profil);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Profil bien modifié.');

      return $this->redirectToRoute('cv_profil_view', array('id' => $Profil->getId()));
    }

    return $this->render('CVProfilBundle:Profil:edit.html.twig', array(
      'Profil' => $Profil,
      'form'   => $form->createView(),
    ));
  }


public function viewAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $Profil = $em->getRepository('CVProfilBundle:Profil')->find($id);

    $listCv = $em
      ->getRepository('CVProfilBundle:CV')
      ->findBy(
      array('profil' => $id),
      array('dateCrea' => 'desc')                     
    );

    $listCom = $em
      ->getRepository('CVProfilBundle:Commentaires')
      ->findBy(
      array('profil' => $id),
      array('dateCrea' => 'desc')                     
    );


 
    $Com = new Commentaires();
    $form   = $this->get('form.factory')->create(CommentaireType::class, $Com);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


      $em2 = $this->getDoctrine()->getManager();
      $user = $this->getUser();
      $user->getId();
      $Com->setRI($user);
      $Com->setProfil($Profil);
      $Profil->setUpdatedAt(new \Datetime());
      $em2->persist($Com);
      $em2->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien enregistré.');

      return $this->redirectToRoute('cv_profil_view', array('id' => $Profil->getId()));
    }

     $query = $em->createQueryBuilder();
      $query1 = $em->createQueryBuilder();
          $query2 = $em->createQueryBuilder();


   $query
            ->select('i.id','i.intitule')
            ->from('CVProfilBundle:Tags', 'p')
            ->innerJoin('p.profil','j')
            ->innerJoin('p.competences','i')
            ->where('j.id = :id')
            ->groupBy('i.intitule')
            ->setParameter('id', $id);

        $listComps = $query->getQuery()->getResult();

           $query1
            ->select('i.id')
            ->from('CVProfilBundle:Tags', 'p')
            ->innerJoin('p.profil','j')
            ->innerJoin('p.experiences','i')
            ->where('j.id = :id')
            ->groupBy('i.id')
            ->setParameter('id', $id);

        $listExp = $query1->getQuery()->getResult();

    $query2
            ->select('p.intitule','count(p.intitule) as cou','i.id','(e.id) as idexp')
            ->from('CVProfilBundle:Tags', 'p')
            ->innerJoin('p.profil','j')
            ->leftJoin('p.competences','i')
            ->leftJoin('p.experiences','e')
            ->where('j.id = :id')
            ->groupBy('p.intitule','i.intitule')
            ->orderBy('cou', 'DESC')
            ->setParameter('id', $id);

        $listTags = $query2->getQuery()->getResult();
 
    if (null === $Profil) {
      throw new NotFoundHttpException("Le profil d'id ".$id." n'existe pas.");
    }

    return $this->render('CVProfilBundle:Profil:view.html.twig', array(
      'Profil'  => $Profil,
      'listCv' => $listCv,
      'listExp' => $listExp,
      'listCom' => $listCom,
      'listComps' => $listComps,
      'listTags' => $listTags,
      'form' => $form->createView(),
    ));

  }

public function addAction(Request $request)
  {
    $Profil = new Profil();
    $form   = $this->get('form.factory')->create(ProfilType::class, $Profil);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


      $em = $this->getDoctrine()->getManager();
      $user = $this->getUser();
      $user->getId();
      $Profil->setRI($user);
      $em->persist($Profil);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Profil bien enregistrée.');

      return $this->redirectToRoute('cv_profil_view', array('id' => $Profil->getId()));
    }

    return $this->render('CVProfilBundle:Profil:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }


public function deleteAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $Profil = $em->getRepository('CVProfilBundle:Profil')->find($id);

        $coms = $em->getRepository('CVProfilBundle:Commentaires')->findBy(
  array('profil' => $id));

    if (null === $Profil) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($Profil);

       foreach ($coms as $com) {
         $em->remove($com);
      }

      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "Le profil a bien été supprimé.");

      return $this->redirectToRoute('cv_profil_liste');
    }
    
    return $this->render('CVProfilBundle:Profil:delete.html.twig', array(
      'Profil' => $Profil,
      'form'   => $form->createView(),
    ));
  }


public function searchAction(Request $request)
  {

     $em = $this->getDoctrine()->getManager();

         $listDomaines = $em
      ->getRepository('CVProfilBundle:Domaines')
      ->findall();


          $listStatut = $em
      ->getRepository('CVProfilBundle:Statut')
      ->findall();

      $query = $em->createQueryBuilder();
 
   $query
            ->select('DISTINCT p')
            ->from('CVProfilBundle:Tags', 'p')
            ->groupBy('p.intitule');

        $listTags = $query->getQuery()->getResult();

    $query2 = $em->createQueryBuilder();
 
   $query2
            ->select('DISTINCT p')
            ->from('CVProfilBundle:Competences', 'p')
            ->groupBy('p.intitule');

        $listComp = $query2->getQuery()->getResult();
  $query3 = $em->createQueryBuilder();
         $query3
            ->select('DISTINCT p')
            ->from('CVProfilBundle:Langues', 'p')
            ->groupBy('p.langage');

        $listLang = $query3->getQuery()->getResult();


$query5 = $em->createQueryBuilder();
         $query5
            ->select('DISTINCT p')
            ->from('CVUserBundle:RI', 'p')
            ->groupBy('p.nom');

$listRi = $query5->getQuery()->getResult();

    if ($request->getMethod() == "POST" || $request->getMethod() == "GET") {

      if ($request->getMethod() == "POST"){

       $search = $request->request->get('search');

      $datas = explode(" / ", $search); 

        $post2 = $request->request->get('domaine');
        $post3 = $request->request->get('statut');
        $post4 = $request->request->get('ri');
        $post5 = $request->request->get('oblig');
        $date_debut = $request->request->get('date_debut');
        $date_fin = $request->request->get('date_fin');
        
      } elseif ($request->getMethod() == "GET"){

        $search = $request->query->get('tag');
        $post5 = explode(" / ", $search);

        $post2 = array();
        $post3 = array();
        $post4 = array();

        if($request->query->get('globalsearch')){

        $globalsearch = $request->query->get('globalsearch');
        $datas = explode(" / ", $globalsearch);
  
        }else{

        $datas = array();

          }

        $date_debut = "2018-05-01";
        $date_fin = date("Y-m-d"); 


      }
    

        $query = $em->createQueryBuilder();
        $query
            ->select('DISTINCT p')
            ->from('CVProfilBundle:Profil', 'p')
            ->leftJoin('p.Domaines','j')
            ->leftJoin('p.tags','i')
            ->leftJoin('i.competences','c')
            ->leftJoin('i.experiences','e')
            ->leftJoin('p.cv','v')
            ->leftJoin('v.langues','l');

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
                ->orWhere('IDENTITY(p.statut) LIKE :data3'.$i3)
                ->setParameter('data3'.$i3, '%'.$data3.'%');
           $i3++;

           }else{

              $query
                ->andWhere('IDENTITY(p.statut) LIKE :data3'.$i3)
                ->setParameter('data3'.$i3, '%'.$data3.'%');

            $i3++; 

          } 
        }

        $i2 = 0;
        foreach ($post2 as $data2) {

            if ($i2 > 0){

          $query
                ->orWhere('j.nom LIKE :data2'.$i2)
                ->setParameter('data2'.$i2, '%'.$data2.'%');
           $i2++;

           }else{

              $query
                ->andWhere('j.nom LIKE :data2'.$i2)
                ->setParameter('data2'.$i2, '%'.$data2.'%');

            $i2++; 

          } 
        }


         $id5 = 0;
        foreach ($post5 as $data5) {

        if ($data5 !== ""){

             if ($id5 > 0){


          $query
                ->orWhere('i.intitule LIKE :data5'.$id5)
                ->setParameter('data5'.$id5, '%'.$data5.'%');
           $id5++;

              }else{


          $query
                ->andWhere('i.intitule LIKE :data5'.$id5)
                ->setParameter('data5'.$id5, '%'.$data5.'%');
           $id5++;

         }
}
        }



      $id = 0; 
        foreach ($datas as $data) {

             if ($id > 0){
            $query
                ->orWhere('p.nom LIKE :data'.$id.' OR p.prenom LIKE :data'.$id.' OR i.intitule LIKE :data'.$id.' OR p.intitule LIKE :data'.$id.' OR c.intitule LIKE :data'.$id.' OR l.langage LIKE :data'.$id)
                ->setParameter('data'.$id, '%'.$data.'%');

                 }else{

            $query
                ->andWhere('p.nom LIKE :data'.$id.' OR p.prenom LIKE :data'.$id.' OR i.intitule LIKE :data'.$id.' OR p.intitule LIKE :data'.$id.' OR c.intitule LIKE :data'.$id.' OR l.langage LIKE :data'.$id)
                ->setParameter('data'.$id, '%'.$data.'%');

                 }
           $id++;
        }

        $idate = 0;
        $query
                ->andWhere('p.dateCrea >= :datad'.$idate.' AND p.dateCrea <= :datab'.$idate)
                ->setParameter('datad'.$idate, $date_debut)
                ->setParameter('datab'.$idate, $date_fin);

  if ($request->getMethod() == "POST"){

                if ($post5[0] !== ""){
$query
      ->groupBy('p.nom')
      ->having('COUNT(DISTINCT i.intitule)=:some_count')
      ->setParameter('some_count',$id5);
}

}
        $listProfils = $query->getQuery()->getResult();    

///////////COUNT///////////////////
    $qb = $em->createQueryBuilder();

    $qb->select('COUNT(DISTINCT p.id) as COU')
        ->from('CVProfilBundle:Profil', 'p' )
         ->leftJoin('p.Domaines','j')
         ->leftJoin('p.tags','i')
          ->leftJoin('i.competences','c')
          ->leftJoin('i.experiences','e')
            ->leftJoin('p.cv','v')
            ->leftJoin('v.langues','l');


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

        $id3 = 0;
        foreach ($post3 as $data3) {

            if ($id3 > 0){

          $qb
                ->orWhere('IDENTITY(p.statut) LIKE :data3'.$id3)
                ->setParameter('data3'.$id3, '%'.$data3.'%');
           $id3++;

           }else{

              $qb
                ->andWhere('IDENTITY(p.statut) LIKE :data3'.$id3)
                ->setParameter('data3'.$id3, '%'.$data3.'%');

            $id3++; 

          } 
        }

        $id2 = 0;
        foreach ($post2 as $data2) {

            if ($id2 > 0){

          $qb
                ->orWhere('j.nom LIKE :data2'.$id2)
                ->setParameter('data2'.$id2, '%'.$data2.'%');
           $i3++;

           }else{

              $qb
                ->andWhere('j.nom LIKE :data2'.$id2)
                ->setParameter('data2'.$id2, '%'.$data2.'%');

            $id2++; 

          } 
        }


          $id5 = 0;
        foreach ($post5 as $data5) {

        if ($data5 !== ""){

             if ($id5 > 0){


          $qb
                ->orWhere('i.intitule LIKE :data5'.$id5)
                ->setParameter('data5'.$id5, '%'.$data5.'%');
           $id5++;

              }else{


          $qb
                ->andWhere('i.intitule LIKE :data5'.$id5)
                ->setParameter('data5'.$id5, '%'.$data5.'%');
           $id5++;

         }
}
        }

        $id = 0; 
        foreach ($datas as $data) {

             if ($id > 0){
            $qb
                ->orWhere('p.nom LIKE :data'.$id.' OR p.prenom LIKE :data'.$id.' OR i.intitule LIKE :data'.$id.' OR p.intitule LIKE :data'.$id.' OR c.intitule LIKE :data'.$id.' OR l.langage LIKE :data'.$id)
                ->setParameter('data'.$id, '%'.$data.'%');

                 }else{

                   $qb
                ->andWhere('p.nom LIKE :data'.$id.' OR p.prenom LIKE :data'.$id.' OR i.intitule LIKE :data'.$id.' OR p.intitule LIKE :data'.$id.' OR c.intitule LIKE :data'.$id.' OR l.langage LIKE :data'.$id)
                ->setParameter('data'.$id, '%'.$data.'%');

                 }
           $id++;
        }

         $idate = 0;
        $qb
                ->andWhere('p.dateCrea >= :datad'.$idate.' AND p.dateCrea <= :datab'.$idate)
                ->setParameter('datad'.$idate, $date_debut)
                ->setParameter('datab'.$idate, $date_fin);

   if ($request->getMethod() == "POST"){ 
             if ($post5[0] !== ""){
$qb
      ->groupBy('p.nom')
      ->having('COUNT(DISTINCT i.intitule)=:some_count')
      ->setParameter('some_count',$id5);
}
}

      $count = $qb->getQuery()->getResult();

if(empty($count)){
$count == 0;
}

////////////////////////////////////////
      $post = $request->request->get('search');
      }

    return $this->render('CVProfilBundle:Profil:liste.html.twig', array(
        'listProfils' => $listProfils,
        'listTags' => $listTags,
        'listDomaines' => $listDomaines,
        'listStatut' => $listStatut,
        'listComp' => $listComp,
        'listLang' => $listLang,
        'listRi' => $listRi,
        'count' => $count,
        'post' => $post,
        'post2' => $post2,
        'post3' => $post3,
        'post4' => $post4,
         'post5' => $post5,
        'date_debut' => $date_debut,
        'date_fin' => $date_fin,
        'datas' => $datas,
       

    ));

  }


public function deletecomAction(Request $request, $id, $id_profil)
  {
    $em = $this->getDoctrine()->getManager();

    $Profil = $em->getRepository('CVProfilBundle:Profil')->find($id_profil);
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
      'Profil'  => $Profil,
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


public function editcomAction(Request $request, $id, $id_profil)
  {
   
    $em = $this->getDoctrine()->getManager();

    $Profil = $em->getRepository('CVProfilBundle:Profil')->find($id_profil);
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

      return $this->redirectToRoute('cv_profil_view', array('id' => $Profil->getId()));
    }

    return $this->render('CVProfilBundle:Profil:editcom.html.twig', array(
      'Profil' => $Profil,
      'Com' => $Com,
      'form'   => $form->createView(),
    ));
  }


}
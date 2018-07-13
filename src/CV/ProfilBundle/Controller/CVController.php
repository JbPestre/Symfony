<?php

// src/cv/ProfilBundle/Controller/ProfilController.php

namespace CV\ProfilBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !
use CV\ProfilBundle\Entity\Profil;
use CV\ProfilBundle\Entity\Fichiers;
use CV\ProfilBundle\Entity\CV;
use CV\ProfilBundle\Entity\Client;
use CV\ProfilBundle\Entity\Experiences;
use CV\ProfilBundle\Entity\Tags;
use CV\ProfilBundle\Entity\Competences;
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
use CV\ProfilBundle\Form\CV\CVEditType;
use CV\ProfilBundle\Form\CV\LanguesType;
use CV\ProfilBundle\Form\CV\FormationType;
use CV\ProfilBundle\Form\CV\TagsType;
use CV\ProfilBundle\Form\CV\CompetencesType;

class CVController extends Controller
{



public function cvAction($id, $id_profil, Request $request)
  {

    $Cv = new Cv();
   

  $form   = $this->get('form.factory')->create(CVType::class, $Cv);

  $em = $this->getDoctrine()->getManager();

  $Client = $em->getRepository('CVProfilBundle:Client')->find($id);

  $Profil = $em->getRepository('CVProfilBundle:Profil')->find($id_profil);

   
$clientno = $request->query->get('id');

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

//Ajout du RI au CV ////


      $Cv->setProfil($Profil);
      if ($clientno == "no_client"){

      $Cv->setClient("");

      }else{

      $Cv->setClient($Client);

      }

      $user = $this->getUser();
      $user->getId();
      $Cv->setRi($user);


      $em->persist($Cv);
      $em->flush();



 //////Ajout de nouveaux prospects/////////     

     $var = $form->get('experiences')->getData();

     foreach ($var as $var2) {

    $id2 = $var2->nomSociete;
    $tagz = $var2->tags;

    $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
          $qb2 = $em->createQueryBuilder();

    $qb->select('count(p.nom)')
        ->from('CVProfilBundle:Client', 'p')
        ->Where('p.nom LIKE :societe')
        ->setParameter('societe', $id2);



      $count = $qb->getQuery()->getSingleScalarResult();


 $em2 = $this->getDoctrine()->getManager();
    if ($count == 0) 

  {
      $Societe_client = new Client();
      $Societe_client->setPays('France');
      $Societe_client->setType(2);
      $Societe_client->setNom($id2);
      $Societe_client->setRi($user);

      $em2->persist($Societe_client);
      $em2->flush();
    }

     $qb2->select('p')
        ->from('CVProfilBundle:Client', 'p')
        ->Where('p.nom LIKE :societe')
        ->setParameter('societe', $id2);
  $Client2 = $qb2->getQuery()->getResult();

         foreach ($tagz as $tagz2) {
foreach ($Client2 as $Clientt) {

        $Clientt->addTag($tagz2);  
      }
        $Profil->addTag($tagz2);
      }


      $em2->flush();

    }

//////////////////Ajout de nouveaux tags pour le profil ///////

$em3 = $this->getDoctrine()->getManager();
  $comp = $form->get('competences')->getData();

     foreach ($comp as $comp2) {

    $tags = $comp2->tags;

      foreach ($tags as $tags2) {

        $Profil->addTag($tags2);
  }

    }

      $em3->flush();

/////////////////////////////////////////////////////////////////





      $request->getSession()->getFlashBag()->add('notice', 'CV bien enregistré.');

      return $this->redirectToRoute('cv_genere', array('id' => $Cv->getId()));
    }

    return $this->render('CVProfilBundle:Cv:add.html.twig', array(
      'Profil' => $Profil,
      'Client' => $Client,
      'form' => $form->createView(),
    ));


  }


public function editcvAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $CV = $em->getRepository('CVProfilBundle:CV')->find($id);

     $Profil = $CV->getProfil();

    if (null === $CV) {
      throw new NotFoundHttpException("Le CV d'id ".$id." n'existe pas.");
    }

    $form = $this->get('form.factory')->create(CVEditType::class, $CV);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

    

      //////Ajout de nouveaux prospects/////////     
     $var = $form->get('experiences')->getData();

     foreach ($var as $var2) {

    $id2 = $var2->nomSociete;
     $tagz = $var2->tags;
    
    $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb2 = $em->createQueryBuilder();

    $qb->select('count(p.nom)')
        ->from('CVProfilBundle:Client', 'p')
        ->Where('p.nom LIKE :societe')
        ->setParameter('societe', $id2);

      $count = $qb->getQuery()->getSingleScalarResult();

 $em2 = $this->getDoctrine()->getManager();

    if ($count == 0) 

  {
      $Societe_client = new Client();
      $Societe_client->setPays('France');
      $Societe_client->setType(2);
      $Societe_client->setNom($id2);
      $Societe_client->setRi($user);
      
      $em2 = $this->getDoctrine()->getManager();
      $em2->persist($Societe_client);
      $em2->flush();
    }


  /*  
   $qb2->select('p')
        ->from('CVProfilBundle:Client', 'p')
        ->Where('p.nom LIKE :societe')
        ->setParameter('societe', $id2);

  $Client2 = $qb2->getQuery()->getResult();

         foreach ($tagz as $tagz2) {
foreach ($Client2 as $Clientt) {

        $Clientt->addTag($tagz2);  
      }
        $Profil->addTag($tagz2);
      }


      $em2->flush();

    }
*/
//////////////////Ajout de nouveaux tags pour le profil ///////
/*
$em3 = $this->getDoctrine()->getManager();
  $comp = $form->get('competences')->getData();

     foreach ($comp as $comp2) {

    $tags = $comp2->tags;

      foreach ($tags as $tags2) {

        $Profil->addTag($tags2);
  }

    }

      $em3->flush();*/
}
/////////////////////////////////////////////////////////////////




      $em->persist($CV);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'CV bien modifié.');

      return $this->redirectToRoute('cv_genere', array('id' => $CV->getId()));
    }

    return $this->render('CVProfilBundle:CV:edit.html.twig', array(
      'CV' => $CV,
      'form'   => $form->createView(),
    ));


  }  


  public function duplicatecvAction($id,$id_client, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $CV = $em->getRepository('CVProfilBundle:CV')->find($id);

 $Client = $em->getRepository('CVProfilBundle:Client')->find($id_client);
 
    $Profil = $CV->getProfil();

   $CVnew = clone $CV;

$clientno = $request->query->get('id_client');

      if ($clientno == "no_client"){

      $Client = $em->getRepository('CVProfilBundle:Client')->find(35);

      $CVnew->setClient($Client);

      }else{

      $CVnew->setClient($Client);

      }

    $form = $this->get('form.factory')->create(CVEditType::class, $CVnew);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


      //////Ajout de nouveaux prospects/////////     
     $var = $form->get('experiences')->getData();

     foreach ($var as $var2) {

    $id2 = $var2->nomSociete;
     $tagz = $var2->tags;
    
    $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb2 = $em->createQueryBuilder();

    $qb->select('count(p.nom)')
        ->from('CVProfilBundle:Client', 'p')
        ->Where('p.nom LIKE :societe')
        ->setParameter('societe', $id2);

      $count = $qb->getQuery()->getSingleScalarResult();

 $em2 = $this->getDoctrine()->getManager();

    if ($count == 0) 

  {
      $Societe_client = new Client();
      $Societe_client->setPays('France');
      $Societe_client->setType(2);
      $Societe_client->setNom($id2);
      $Societe_client->setRi($user);
      
      $em2 = $this->getDoctrine()->getManager();
      $em2->persist($Societe_client);
      $em2->flush();
    }

}



      $em->persist($CVnew);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'CV bien modifié.');

      return $this->redirectToRoute('cv_genere', array('id' => $CVnew->getId()));
    }

    return $this->render('CVProfilBundle:CV:duplicate.html.twig', array(
      'CVnew' => $CVnew,
      'form'   => $form->createView(),
    ));


  }  

  public function attacheAction($id_profil, Request $request)
  {
    // ...
 $em = $this->getDoctrine()->getManager();

    // Notre liste d'annonce en dur
     $listClients = $em
      ->getRepository('CVProfilBundle:Client')
      ->findAll()
    ;
$Profil = $em->getRepository('CVProfilBundle:Profil')->find($id_profil);

    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('CVProfilBundle:Cv:cvclient.html.twig', array(
      'listClients' => $listClients,
      'Profil' => $Profil,
    ));

}


public function viewcvAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $Cv = $em->getRepository('CVProfilBundle:CV')->find($id);


    if (null === $Cv) {
      throw new NotFoundHttpException("N'existe pas.");
    }

    return $this->render('CVProfilBundle:Cv:cv.html.twig', array(
      'Cv'           => $Cv,
    ));


    $html = $this->renderView('CVProfilBundle:Cv:cv.html.twig', array(
            'Cv'           => $Cv,
        ));
    
     return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );


  }


public function indexcvAction()
  {
    // ...
 $em = $this->getDoctrine()->getManager();

    // Notre liste d'annonce en dur
     $listCv = $em
      ->getRepository('CVProfilBundle:CV')
      ->findAll()
    ;


    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('CVProfilBundle:Cv:index.html.twig', array(
      'listCv' => $listCv,
    ));

  }

public function deletecvAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $CV = $em->getRepository('CVProfilBundle:CV')->find($id);

    if (null === $CV) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($CV);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "Le cv a bien été supprimé.");

      return $this->redirectToRoute('cv_homecv');
    }

     return $this->render('CVProfilBundle:Cv:delete.html.twig', array(
      'CV' => $CV,
      'form'   => $form->createView(),
    ));
}

public function pdfAction($id, Request $request)
    {
        
      $em = $this->getDoctrine()->getManager();

    $Cv = $em->getRepository('CVProfilBundle:CV')->find($id);

    $Cvid = $Cv->getProfil();

    $Profil = $em->getRepository('CVProfilBundle:Profil')->findOneBy(array('id' => $Cvid));

      $user = $Profil->getPrenom();
      $statut = $Profil->getStatut();
  
    $pdf = $this->get("white_october.tcpdf")->create();
    $pdf->SetAuthor('TRSb');
    $pdf->SetTitle('Test PDF TRSb');
    $pdf->SetSubject('');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $pdf->AddPage();
    $pdf->lastPage();

    $pdf->Cell( 0, 10, $user, 0, 0, 'R' ); 
    $pdf->Cell( 0, 20, $statut, 0, 0, 'R' ); 
    $pdf->Image('http://www.trsb.net/wp-content/uploads/2017/03/NEW-LOGO-TRSB.png',10,12,35,0,'PNG');

    $html = $this->renderView(
         'CVProfilBundle:Cv:cvpdf.html.twig',
         array(
           'Cv' => $Cv,
         )
    );
    $pdf->SetFont('helvetica', '', 10, '', true);
     $pdf -> writeHTML($html);
    $response = new Response($pdf->Output('CV '.$user.' 2017-2018.pdf','D'));
    $response->headers->set('Content-Type', 'application/pdf');
 
    return $response;


   }



public function testcvAction(Request $request)
  {
    $Comp = new Competences();
    $form   = $this->get('form.factory')->create(CompetencesType::class, $Comp);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $em->persist($Comp);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Profil bien enregistrée.');

      return $this->redirectToRoute('cv_homecv');
    }

    return $this->render('CVProfilBundle:CV:tags.html.twig', array(
      'form' => $form->createView(),
    ));
  }


public function searchcvAction(Request $request)
  {

    $search = $request->request->get('search');
    $id_profil = $request->query->get('id_profil');
    $em = $this->getDoctrine()->getManager();

    $id5 = 0;
        $query = $em->createQueryBuilder();
        $query
            ->select('DISTINCT p')
            ->from('CVProfilBundle:Client', 'p')
               ->Where('p.nom LIKE :search'.$id5)
                ->setParameter('search'.$id5, '%'.$search.'%');

$listClients = $query->getQuery()->getResult();  
$Profil = $em->getRepository('CVProfilBundle:Profil')->find($id_profil);

    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('CVProfilBundle:Cv:cvclient.html.twig', array(
      'listClients' => $listClients,
      'Profil' => $Profil,
       'search' => $search,
    ));
  }

public function searchcvduplAction(Request $request)
  {

    $search = $request->request->get('search');
    $id = $request->query->get('id');
    $em = $this->getDoctrine()->getManager();

    $id5 = 0;
        $query = $em->createQueryBuilder();
        $query
            ->select('DISTINCT p')
            ->from('CVProfilBundle:Client', 'p')
               ->Where('p.nom LIKE :search'.$id5)
                ->setParameter('search'.$id5, '%'.$search.'%');

$listClients = $query->getQuery()->getResult();  
$Cv = $em->getRepository('CVProfilBundle:CV')->find($id);

    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('CVProfilBundle:Cv:duplicatelist.html.twig', array(
      'listClients' => $listClients,
      'Cv' => $Cv,
       'search' => $search,
    ));
  }

  public function attacheduplAction($id, Request $request)
  {
    // ...
 $em = $this->getDoctrine()->getManager();

    // Notre liste d'annonce en dur
     $listClients = $em
      ->getRepository('CVProfilBundle:Client')
      ->findAll()
    ;
$Cv = $em->getRepository('CVProfilBundle:CV')->find($id);

    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('CVProfilBundle:Cv:duplicatelist.html.twig', array(
      'listClients' => $listClients,
      'Cv' => $Cv,
    ));

}


}
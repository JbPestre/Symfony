<?php


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
use CV\ProfilBundle\Entity\Interlocuteur;
use CV\ProfilBundle\Entity\Commentaires;
use CV\ProfilBundle\Entity\Actions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use CV\ProfilBundle\Form\Contact\ContactType;
use CV\ProfilBundle\Form\Contact\ActionsType;
use CV\ProfilBundle\Form\Contact\ActionsEditType;
use CV\ProfilBundle\Form\Profil\FichierType;
use CV\ProfilBundle\Form\Contact\ContactEditType;

class ContactController extends Controller
{

public function viewAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $Contact = $em->getRepository('CVProfilBundle:Interlocuteur')->find($id);
    
    $listActions = $em
      ->getRepository('CVProfilBundle:Actions')
      ->findBy(
      array('interlocuteur' => $id),
      array('dateAction' => 'ASC')                     
    );


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

$query = $em->createQueryBuilder();


   $query
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0 and p.interlocuteur = '.$id);

  $listActions = $query->getQuery()->getResult();

} else if(isset($avenir)){

$isavenir = "oui";
$isnonvalide = "non";
$isvalide = "non";
$scroll = "present";

$query = $em->createQueryBuilder();


   $query
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0 and p.dateAction >= :now and p.interlocuteur = '.$id)
            ->setParameter('now', new \DateTime('now'));

  $listActions = $query->getQuery()->getResult();

} else if(isset($valide)){

$isavenir = "non";
$isnonvalide = "non";
$isvalide = "oui";
$scroll = "present";

$query = $em->createQueryBuilder();

   $query
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide > 0 and p.interlocuteur = '.$id);

$listActions = $query->getQuery()->getResult();

}


$query2 = $em->createQueryBuilder();
$query3 = $em->createQueryBuilder();
$query4 = $em->createQueryBuilder();

  $query2
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0 and p.interlocuteur = '.$id);

  $query3
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0 and p.dateAction >= :now and p.interlocuteur = '.$id)
            ->setParameter('now', new \DateTime('now'));

  $query4
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide > 0 and p.interlocuteur = '.$id);

  $countnonvalide = $query2->getQuery()->getOneOrNullResult();
  $countavenir = $query3->getQuery()->getOneOrNullResult();
  $countvalide = $query4->getQuery()->getOneOrNullResult();



     return $this->render('CVProfilBundle:Contact:view.html.twig', array(
    'Contact' => $Contact,
    'listActions' => $listActions,
    'isavenir' => $isavenir,
    'isvalide' => $isvalide,
    'isnonvalide' => $isnonvalide,
    'countnonvalide' => $countnonvalide,
    'countavenir' => $countavenir,
    'countvalide' => $countvalide,
    'scroll' => $scroll,
    
    ));


  }

public function viewactionAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $Actions = $em->getRepository('CVProfilBundle:Actions')->find($id);
    
          $client = $Actions->getInterlocuteur();

           $listClients = $em
      ->getRepository('CVProfilBundle:Interlocuteur')
      ->findBy(
      array('id' => $client)                   
    );
      
    if (null === $Actions) {
      throw new NotFoundHttpException("L'action d'id ".$id." n'existe pas.");
    }

$validation = $request->request->get('validation');
$invalidation = $request->request->get('invalidation');
$newdatevalidation = $request->request->get('newdatevalidation');
$newdate = new \DateTime($request->request->get('newdate'));

    if(isset($validation)){

 $actionselec = $em
      ->getRepository('CVProfilBundle:Actions')
      ->find($validation);

$actionselec->setValide(true);
$em->flush();


 return $this->redirectToRoute('cv_profil_viewaction', array('id' => $Actions->getId()));
}

 if(isset($invalidation)){

 $actionselec = $em
      ->getRepository('CVProfilBundle:Actions')
      ->find($invalidation);

$actionselec->setValide(false);
$em->flush();


 return $this->redirectToRoute('cv_profil_viewaction', array('id' => $Actions->getId()));
}

if(isset($newdatevalidation)){


 $actionselec1 = $em
      ->getRepository('CVProfilBundle:Actions')
      ->find($newdatevalidation);

$actionselec1->setDateAction($newdate);
$actionselec1->setValide(false);
$em->flush($actionselec1);

 return $this->redirectToRoute('cv_profil_viewaction', array('id' => $Actions->getId()));
}

    return $this->render('CVProfilBundle:Contact:viewaction.html.twig', array(
    'Actions' => $Actions,
    'listClients' => $listClients,
    ));

  }


public function addAction($id, Request $request)
  {
    $Contact = new Interlocuteur();

    $em = $this->getDoctrine()->getManager();

    $Client = $em->getRepository('CVProfilBundle:Client')->find($id);


    $form   = $this->get('form.factory')->create(ContactType::class, $Contact);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $user = $this->getUser();
      $user->getId();
      $Contact->setClient($Client);
      $Contact->setRI($user);
      $em->persist($Contact);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Profil bien enregistrée.');

      return $this->redirectToRoute('cv_profil_viewcontact', array('id' => $Contact->getId()));
    }

    return $this->render('CVProfilBundle:Contact:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }


public function addactionAction($id, Request $request)
  {
    $Action = new Actions();

    $em = $this->getDoctrine()->getManager();

    $Contact = $em->getRepository('CVProfilBundle:Interlocuteur')->find($id);

    $form   = $this->get('form.factory')->create(ActionsType::class, $Action);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $user = $this->getUser();
      $user->getId();
      $Action->setInterlocuteur($Contact);
      $Action->setRI($user);
      $em->persist($Action);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Action bien enregistrée.');

      return $this->redirectToRoute('cv_profil_viewcontact', array('id' => $Contact->getId()));
    }

    return $this->render('CVProfilBundle:Contact:addaction.html.twig', array(
      'form' => $form->createView(),
    ));
  }

public function editactionAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $Action = $em->getRepository('CVProfilBundle:Actions')->find($id);

    if (null === $Action) {
      throw new NotFoundHttpException("L'action d'id ".$id." n'existe pas.");
    }

    $form = $this->get('form.factory')->create(ActionsEditType::class, $Action);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('cv_profil_viewaction', array('id' => $Action->getId()));
    }

    return $this->render('CVProfilBundle:Contact:editaction.html.twig', array(
      'Action' => $Action,
      'form'   => $form->createView(),
    ));
  }


    public function deleteactionAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $Actions = $em->getRepository('CVProfilBundle:Actions')->find($id);


    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($Actions);  
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'action a bien été supprimé.");

      return $this->redirectToRoute('cv_agenda');
    }
    
    return $this->render('CVProfilBundle:Contact:deleteaction.html.twig', array(
      'Actions' => $Actions,
      'form'   => $form->createView(),
    ));
  }


  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $Contact = $em->getRepository('CVProfilBundle:Interlocuteur')->find($id);

    $form = $this->get('form.factory')->create(ContactEditType::class, $Contact);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $em->flush();

      return $this->redirectToRoute('cv_profil_viewcontact', array('id' => $Contact->getId()));
    }

    return $this->render('CVProfilBundle:Contact:edit.html.twig', array(
      'Contact' => $Contact,
      'form'   => $form->createView(),
    ));
  }


  public function deleteAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $Contact = $em->getRepository('CVProfilBundle:Interlocuteur')->find($id);


    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($Contact);  
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "Le contact a bien été supprimé.");

      return $this->redirectToRoute('cv_profil_homeclient');
    }
    
    return $this->render('CVProfilBundle:Contact:delete.html.twig', array(
      'Contact' => $Contact,
      'form'   => $form->createView(),
    ));
  }



}
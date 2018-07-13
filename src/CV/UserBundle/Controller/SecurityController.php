<?php
// src/OC/UserBundle/Controller/SecurityController.php;

namespace CV\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use CV\ProfilBundle\Entity\Domaines;
use CV\ProfilBundle\Entity\Statut;
use CV\ProfilBundle\Entity\Pays;
use CV\UserBundle\Entity\RI;
use CV\ProfilBundle\Entity\Type_action;
use CV\ProfilBundle\Entity\Type_client;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SecurityController extends Controller
{
  public function loginAction(Request $request)
  {
    // Si le visiteur est déjà identifié, on le redirige vers l'accueil
    if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      return $this->redirectToRoute('cv_profil_liste');
    }

    // Le service authentication_utils permet de récupérer le nom d'utilisateur
    // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
    // (mauvais mot de passe par exemple)
    $authenticationUtils = $this->get('security.authentication_utils');

    return $this->render('CVUserBundle:Security:login.html.twig', array(
      'last_username' => $authenticationUtils->getLastUsername(),
      'error'         => $authenticationUtils->getLastAuthenticationError(),
    ));
  }

public function modifpwdAction(Request $request)
  {


    $em = $this->getDoctrine()->getManager();

    $user = $this->getUser();
    $mdp = $user->getPassword(); 

  $Domaines = new Domaines(); 
 
     $form = $this->createFormBuilder($user)
            ->add('password', RepeatedType::class, array(
    'type' => PasswordType::class,
    'invalid_message' => 'Les deux mots de passe ne sont pas identiques.',
    'options' => array('attr' => array('class' => 'password-field')),
    'required' => true,
    'first_options'  => array('label' => 'Nouveau mot de passe'),
    'second_options' => array('label' => 'Répéter le nouveau mot de passe'),))
            ->add('Modifier', SubmitType::class,array('label' => 'Valider la modification'))
            ->getForm();

     $form2 = $this->createFormBuilder($user)
    ->add('nom', TextType::class)
    ->add('prenom', TextType::class)
    ->add('username', TextType::class)
    ->add('modify', SubmitType::class,array('label' => 'Valider la modification'))
    ->getForm();   



    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid() && $form->get('Modifier')->isClicked()) {
      $em->flush($user);

      $request->getSession()->getFlashBag()->add('notice', 'Mot de passe bien modifié.');

      return $this->redirectToRoute('cv_settings', array('id' => $user->getId()));
    }

        if ($request->isMethod('POST') && $form2->handleRequest($request)->isValid() && $form2->get('modify')->isClicked()) {
      $user->setPassword($mdp);
      $em->flush($user);

      $request->getSession()->getFlashBag()->add('notice', 'Infos bien modifié.');

      return $this->redirectToRoute('cv_settings', array('id' => $user->getId()));
    }



    return $this->render('CVUserBundle:Security:settings.html.twig', array(
      'user' => $user,
      'form'   => $form->createView(),
      'form2'   => $form2->createView(),
    ));

        
  }
   public function gestionriAction(Request $request)
  {


$p_lc_letters = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 6); 
$p_uc_letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 1); 
$p_numbers = substr(str_shuffle('0123456789'), 0, 1); 

$password = substr(str_shuffle($p_lc_letters.''.$p_uc_letters.''.$p_numbers), 0, 8);

    $em = $this->getDoctrine()->getManager();
    $user = $this->getUser();
    $query7 = $em->createQueryBuilder();

        $query7
            ->select('p')
            ->from('CVUserBundle:RI', 'p')
            ->orderBy('p.nom', 'ASC');

        $listRi = $query7->getQuery()->getResult();

          $RI = new RI();


            $form6 = $this->createFormBuilder($RI)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('password', TextType::class,array('data' => $password))
            ->add('username', TextType::class,array('data' => '@'))
            ->add('Addri', SubmitType::class,array('label' => 'Ajouter'))
            ->getForm();   

    if ($request->isMethod('POST') && $form6->handleRequest($request)->isValid() && $form6->get('Addri')->isClicked()) {
      $em->persist($RI);
      $em->flush($RI);

      $request->getSession()->getFlashBag()->add('notice', 'Ri bien modifié.');

      return $this->redirectToRoute('cv_gestion', array('id' => $user->getId()));

    }

 if(isset($supprri)){

      $TypeClient = $em->getRepository('CVUserBundle:RI')->findOneBy(array('nom' => $supprri));
      
      $em->remove($RI);
      $em->flush();
      return $this->redirectToRoute('cv_gestion');
    }

    if(isset($modifri)){

      $RI = $em->getRepository('CVUserBundle:RI')->find($modifricid);
      
      $RI->setNom($modifri);
      $em->flush($RI);
      return $this->redirectToRoute('cv_gestion');
    }


    return $this->render('CVUserBundle:Security:gestionri.html.twig', array(
      'listRi' => $listRi,
       'password' => $password,
      'form6'   => $form6->createView(),
    ));



  }


  public function gestionAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    

 $query2 = $em->createQueryBuilder();
        $query2
            ->select('p')
            ->from('CVProfilBundle:Domaines', 'p')
            ->orderBy('p.nom', 'ASC');

        $listDomaines = $query2->getQuery()->getResult();

 $query3 = $em->createQueryBuilder();
        $query3
            ->select('p')
            ->from('CVProfilBundle:Statut', 'p')
            ->orderBy('p.nom', 'ASC');

        $listStatut = $query3->getQuery()->getResult();

   $query4 = $em->createQueryBuilder();
        $query4
            ->select('p')
            ->from('CVProfilBundle:Pays', 'p')
            ->orderBy('p.nom', 'ASC');

        $listPays = $query4->getQuery()->getResult();

  $query5 = $em->createQueryBuilder();
        $query5
            ->select('p')
            ->from('CVProfilBundle:Type_action', 'p')
            ->orderBy('p.nom', 'ASC');

        $listTypeAction = $query5->getQuery()->getResult();

    $query6 = $em->createQueryBuilder();
        $query6
            ->select('p')
            ->from('CVProfilBundle:Type_client', 'p')
            ->orderBy('p.nom', 'ASC');

        $listTypes = $query6->getQuery()->getResult();


    $user = $this->getUser();

  $Domaines = new Domaines(); 
  $Statut = new Statut();
  $Pays = new Pays();
  $TypeAction = new Type_action();
  $TypeClient = new Type_client();

 
  $form1 = $this->createFormBuilder($Domaines)
            ->add('nom', TextType::class)
            ->add('ajouter', SubmitType::class)
            ->getForm();

    $form2 = $this->createFormBuilder($Statut)
            ->add('nom', TextType::class)
            ->add('Ajouter', SubmitType::class)
            ->getForm();

    $form3 = $this->createFormBuilder($Pays)
            ->add('nom', TextType::class)
            ->add('Add', SubmitType::class,array('label' => 'Ajouter'))
            ->getForm();

    $form4 = $this->createFormBuilder($TypeAction)
            ->add('nom', TextType::class)
            ->add('Adds', SubmitType::class,array('label' => 'Ajouter'))
            ->getForm();         

    $form5 = $this->createFormBuilder($TypeClient)
            ->add('nom', TextType::class)
            ->add('Addz', SubmitType::class,array('label' => 'Ajouter'))
            ->getForm(); 
      
   
    $supprdomaine = $request->request->get('supprdomaine');    
    $modifdomaine = $request->request->get('modifdomaine'); 
    $modifdomaineid = $request->request->get('modifdomaineid');    
    $supprstatut = $request->request->get('supprstatut');    
    $modifstatut = $request->request->get('modifstatut'); 
    $modifstatutid = $request->request->get('modifstatutid');
    $supprpays = $request->request->get('supprpays');    
    $modifpays = $request->request->get('modifpays'); 
    $modifpaysid = $request->request->get('modifpaysid');
    $supprtype = $request->request->get('supprtype');    
    $modiftype = $request->request->get('modiftype'); 
    $modiftypeid = $request->request->get('modiftypeid');
    $supprtypec = $request->request->get('supprtypec');    
    $modiftypec = $request->request->get('modiftypec'); 
    $modiftypecid = $request->request->get('modiftypecid');
    $supprri = $request->request->get('supprri');    
    $modifri = $request->request->get('modifri'); 
    $modifriid = $request->request->get('modifriid');


    if ($request->isMethod('POST') && $form1->handleRequest($request)->isValid() && $form1->get('ajouter')->isClicked()) {
      $em->persist($Domaines);
      $em->flush($Domaines);

      $request->getSession()->getFlashBag()->add('notice', 'Domaines bien modifiés.');

      return $this->redirectToRoute('cv_gestion', array('id' => $user->getId()));
    }

    if ($request->isMethod('POST') && $form2->handleRequest($request)->isValid() && $form2->get('Ajouter')->isClicked()) {
      $em->persist($Statut);
      $em->flush($Statut);

      $request->getSession()->getFlashBag()->add('notice', 'Statut bien modifié.');

      return $this->redirectToRoute('cv_gestion', array('id' => $user->getId()));
    }

     if ($request->isMethod('POST') && $form3->handleRequest($request)->isValid() && $form3->get('Add')->isClicked()) {
      $em->persist($Pays);
      $em->flush($Pays);

      $request->getSession()->getFlashBag()->add('notice', 'Pays bien modifié.');

      return $this->redirectToRoute('cv_gestion', array('id' => $user->getId()));
    }

      if ($request->isMethod('POST') && $form4->handleRequest($request)->isValid() && $form4->get('Adds')->isClicked()) {
      $em->persist($TypeAction);
      $em->flush($TypeAction);

      $request->getSession()->getFlashBag()->add('notice', 'Type Action bien modifié.');

      return $this->redirectToRoute('cv_gestion', array('id' => $user->getId()));
    }

    if ($request->isMethod('POST') && $form5->handleRequest($request)->isValid() && $form5->get('Addz')->isClicked()) {
      $em->persist($TypeClient);
      $em->flush($TypeClient);

      $request->getSession()->getFlashBag()->add('notice', 'Type Client bien modifié.');

      return $this->redirectToRoute('cv_gestion', array('id' => $user->getId()));
    }




    if ($request->getMethod() == "POST"){

    if(isset($supprdomaine)){

      $Domaine = $em->getRepository('CVProfilBundle:Domaines')->findOneBy(array('nom' => $supprdomaine));
      
      $em->remove($Domaine);
      $em->flush();
      return $this->redirectToRoute('cv_gestion');
    }

    if(isset($modifdomaine)){

      $Domaine = $em->getRepository('CVProfilBundle:Domaines')->find($modifdomaineid);
      
      $Domaine->setNom($modifdomaine);
      $em->flush($Domaine);
      return $this->redirectToRoute('cv_gestion');
    }

    if(isset($supprstatut)){

      $Statut = $em->getRepository('CVProfilBundle:Statut')->findOneBy(array('nom' => $supprstatut));
      
      $em->remove($Statut);
      $em->flush();
      return $this->redirectToRoute('cv_gestion');
    }

    if(isset($modifstatut)){

      $Statut = $em->getRepository('CVProfilBundle:Statut')->find($modifstatutid);
      
      $Statut->setNom($modifstatut);
      $em->flush($Statut);
      return $this->redirectToRoute('cv_gestion');
    }

     if(isset($supprpays)){

      $Pays = $em->getRepository('CVProfilBundle:Pays')->findOneBy(array('nom' => $supprpays));
      
      $em->remove($Pays);
      $em->flush();
      return $this->redirectToRoute('cv_gestion');
    }

    if(isset($modifpays)){

      $Pays = $em->getRepository('CVProfilBundle:Pays')->find($modifpaysid);
      
      $Pays->setNom($modifpays);
      $em->flush($Pays);
      return $this->redirectToRoute('cv_gestion');
    }


     if(isset($supprtype)){

      $TypeAction = $em->getRepository('CVProfilBundle:Type_action')->findOneBy(array('nom' => $supprtype));
      
      $em->remove($TypeAction);
      $em->flush();
      return $this->redirectToRoute('cv_gestion');
    }

    if(isset($modiftype)){

      $TypeAction = $em->getRepository('CVProfilBundle:Type_action')->find($modiftypeid);
      
      $TypeAction->setNom($modiftype);
      $em->flush($TypeAction);
      return $this->redirectToRoute('cv_gestion');
    }

     if(isset($supprtypec)){

      $TypeClient = $em->getRepository('CVProfilBundle:Type_client')->findOneBy(array('nom' => $supprtypec));
      
      $em->remove($TypeClient);
      $em->flush();
      return $this->redirectToRoute('cv_gestion');
    }

    if(isset($modiftypec)){

      $TypeClient = $em->getRepository('CVProfilBundle:Type_client')->find($modiftypecid);
      
      $TypeClient->setNom($modiftypec);
      $em->flush($TypeClient);
      return $this->redirectToRoute('cv_gestion');
    }

    }


    return $this->render('CVUserBundle:Security:gestion.html.twig', array(
      'listDomaines' => $listDomaines,
      'listStatut' => $listStatut,
      'listPays' => $listPays,
      'listTypeAction' => $listTypeAction,
      'listTypes' => $listTypes,
      'user' => $user,
      'form1'   => $form1->createView(),
      'form2'   => $form2->createView(),
      'form3'   => $form3->createView(),
      'form4'   => $form4->createView(),
      'form5'   => $form5->createView(),
    ));

        
  }

  public function agendaAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

       $user = $this->getUser();
       $iduser = $user->getId();

   $query = $em->createQueryBuilder();


   $query
            ->select('p','j')
            ->from('CVProfilBundle:Actions', 'p')
            ->innerJoin('p.interlocuteur','j')
            ->innerJoin('j.client','i')
            ->where('p.valide = 0')
            ->orderBy('p.dateAction','ASC');

  $listActions = $query->getQuery()->getResult();

      foreach ($listActions as $actions) {
          $client = $actions->getInterlocuteur();

           $listClients = $em
      ->getRepository('CVProfilBundle:Interlocuteur')
      ->findBy(
      array('id' => $client)                   
    );
      }


      $query2 = $em->createQueryBuilder();
$query3 = $em->createQueryBuilder();
$query4 = $em->createQueryBuilder();

  $query2
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0');

  $query3
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0 and p.dateAction >= :now')
            ->setParameter('now', new \DateTime('now'));

  $query4
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide > 0');

  $countnonvalide = $query2->getQuery()->getOneOrNullResult();
  $countavenir = $query3->getQuery()->getOneOrNullResult();
  $countvalide = $query4->getQuery()->getOneOrNullResult();

  $isavenir = "non";
$isnonvalide = "oui";
$isvalide = "non";

    return $this->render('CVUserBundle:Security:agenda.html.twig', array(
    'listActions' => $listActions,
    'listClients' => $listClients,
    'isavenir' => $isavenir,
    'isvalide' => $isvalide,
    'isnonvalide' => $isnonvalide,
    'countnonvalide' => $countnonvalide,
    'countavenir' => $countavenir,
    'countvalide' => $countvalide,
    ));

  }

  public function searchAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

       $user = $this->getUser();
         $iduser = $user->getId();

$valide = $request->request->get('valide');
$nonvalide = $request->request->get('nonvalide');
$avenir = $request->request->get('avenir');
$validation = $request->request->get('validation');
$newdatevalidation = $request->request->get('newdatevalidation');
$newdate = new \DateTime($request->request->get('newdate'));

if ($request->getMethod() == "POST"){


if(isset($nonvalide)){

$isavenir = "non";
$isnonvalide = "oui";
$isvalide = "non";

$query = $em->createQueryBuilder();


   $query
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0');

  $listActions = $query->getQuery()->getResult();

} else if(isset($avenir)){

$isavenir = "oui";
$isnonvalide = "non";
$isvalide = "non";

$query = $em->createQueryBuilder();


   $query
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0 and p.dateAction >= :now')
            ->setParameter('now', new \DateTime('now'));

  $listActions = $query->getQuery()->getResult();

} else if(isset($valide)){

$isavenir = "non";
$isnonvalide = "non";
$isvalide = "oui";

$query = $em->createQueryBuilder();

   $query
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide > 0');

$listActions = $query->getQuery()->getResult();

}


if(isset($validation)){

$query = $em->createQueryBuilder();


   $query
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0');

  $listActions = $query->getQuery()->getResult();



 $actionselec = $em
      ->getRepository('CVProfilBundle:Actions')
      ->find($validation);

$actionselec->setValide(true);
$em->flush();


 return $this->redirectToRoute('cv_agenda');
}

if(isset($newdatevalidation)){

$query = $em->createQueryBuilder();


   $query
            ->select('p')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0');

  $listActions = $query->getQuery()->getResult();



 $actionselec1 = $em
      ->getRepository('CVProfilBundle:Actions')
      ->find($newdatevalidation);

$actionselec1->setDateAction($newdate);
$actionselec1->setValide(false);
$em->flush($actionselec1);

 return $this->redirectToRoute('cv_agenda');
}




if(empty($listActions)) {
  
  $listClients = "non";

}else{

      foreach ($listActions as $actions) {
          $client = $actions->getInterlocuteur();

           $listClients = $em
      ->getRepository('CVProfilBundle:Interlocuteur')
      ->findBy(
      array('id' => $client)                   
    );
      }

}


    }

$query2 = $em->createQueryBuilder();
$query3 = $em->createQueryBuilder();
$query4 = $em->createQueryBuilder();

  $query2
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0');

  $query3
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide = 0 and p.dateAction >= :now')
            ->setParameter('now', new \DateTime('now'));

  $query4
            ->select('count(p)')
            ->from('CVProfilBundle:Actions', 'p')
            ->where('p.valide > 0 and p.ri = '.$iduser);

  $countnonvalide = $query2->getQuery()->getOneOrNullResult();
  $countavenir = $query3->getQuery()->getOneOrNullResult();
  $countvalide = $query4->getQuery()->getOneOrNullResult();





    return $this->render('CVUserBundle:Security:agenda.html.twig', array(
    'listActions' => $listActions,
    'listClients' => $listClients,
    'isnonvalide' => $isnonvalide,
    'isvalide' => $isvalide,
    'isavenir' => $isavenir,
    'countnonvalide' => $countnonvalide,
    'countavenir' => $countavenir,
    'countvalide' => $countvalide,
    ));

  }

}

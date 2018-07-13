<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="cv_profil")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
       return $this->redirectToRoute('cv_profil_liste');
    }

     public function searchAction(Request $request)
   {


        $type = $request->request->get('search_param');
        $search = $request->request->get('search');

     if ($request->getMethod() == "POST"){


        if($type=="Profil"){

        return $this->redirectToRoute('cv_profil_search', array('globalsearch' => $search));

        } elseif($type == "CV"){

        return $this->redirectToRoute('cv_homecv');

        } elseif($type == "Entreprise"){

         return $this->redirectToRoute('cv_profil_searchclient', 
          array('globalsearch' => $search,
                'typesearch' => $type));

        } elseif($type == "Interlocuteur"){ 


         return $this->redirectToRoute('cv_profil_searchclient', 
          array('globalsearch' => $search,
                'typesearch' => $type));
        }


     }
   }


}

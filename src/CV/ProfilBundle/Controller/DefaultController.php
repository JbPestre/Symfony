<?php

namespace CV\ProfilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CVProfilBundle:Default:index.html.twig');
    }
}

<?php

namespace Flock\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

class DefaultController extends Controller
{
    /**
     * @Extra\Route("/", name="flock_home")
     * @return Flock\MainBundle\Controller\DefaultController
    */
    public function indexAction()
    {
        return $this->render('FlockMainBundle:Default:index.html.twig', array());
    }

    /**
     * @Extra\Route("/login", name="flock_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        return new Response();
    }
}

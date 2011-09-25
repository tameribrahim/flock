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
     *
     * @return Flock\MainBundle\Controller\DefaultController
    */
    public function indexAction()
    {
        return $this->render('FlockMainBundle:Default:index.html.twig', array());
    }

    /**
     * @Extra\Route("/about", name="flock_about")
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function aboutAction()
    {
        return $this->render('FlockMainBundle:Default:about.html.twig', array());
    }
}

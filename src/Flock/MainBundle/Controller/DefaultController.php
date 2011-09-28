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
     * @Extra\Template("FlockMainBundle:Default:index.html.twig")
     *
     * @return array
    */
    public function indexAction()
    {
        $activities = $this->getDoctrine()->getRepository('FlockMainBundle:Activity')
            ->getLatestActivity(20);

        $flockCount = $this->getDoctrine()->getRepository('FlockMainBundle:Flock')
            ->getActiveFlocksCount();

        $userCount = $this->getDoctrine()->getRepository('FlockMainBundle:User')
            ->getActiveUsersCount();

        return array(
            'activities' => $activities,
            'flocksCount' => $flockCount,
            'usersCount' =>$userCount,
        );
    }

    /**
     * @Extra\Route("/login", name="flock_login")
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function loginAction()
    {
        if ($this->get('security.context')->getToken()->getUser() instanceof \Flock\MainBundle\Entity\User) {
            return new RedirectResponse($this->generateUrl('flock_home'));
        }

        return $this->render('FlockMainBundle:Default:login.html.twig', array());
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

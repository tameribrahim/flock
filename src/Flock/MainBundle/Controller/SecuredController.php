<?php
/**
 * Created by Amal Raghav <amal.raghav@gmail.com>
 * Date: 11/06/11
 */

namespace Flock\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

/**
 * @Extra\Route("/secured")
 */
class SecuredController extends Controller
{
    /**
     * @Extra\Route("/", name="_secured_home")
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function indexAction()
    {
        return $this->render('FlockMainBundle:Default:index.html.twig', array());
    }
}

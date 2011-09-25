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
use Symfony\Component\HttpFoundation\Request;

/**
 * @Extra\Route("/auth")
 */
class AuthController extends Controller
{
    /**
     * @Extra\Route("/twitter", name="twitter_auth")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return void
     */
    public function twitterAction(Request $request)
    {
        $redirectTo = $request->headers->get('referer') ?: '/';
        return new RedirectResponse($redirectTo);
    }
}

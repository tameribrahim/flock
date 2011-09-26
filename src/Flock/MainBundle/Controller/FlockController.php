<?php
/**
 * Created by Amal Raghav <amal.raghav@gmail.com>
 * Date: 07/05/11
 */

namespace Flock\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Flock\MainBundle\Entity\Flock;
use Flock\MainBundle\Entity\User;
use Flock\MainBundle\Form\FlockForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\Request;

class FlockController extends Controller
{
    /**
     * @Extra\Route("/create", name="flock_create")
     * @Extra\Template("FlockMainBundle:Flock:create.html.twig")
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction()
    {
        $em = $this->get('doctrine')->getEntityManager();
        $flock = new Flock();

        $form = $this->buildForm($flock);

        if ($this->get('request')->getMethod() === 'POST') {
            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {
                $flock->setUser($this->get('security.context')->getToken()->getUser());
                $em->persist($flock);
                $em->flush();

                return new RedirectResponse($this->generateUrl('flock_show', array('id' => $flock->getId())));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Extra\Route("/list/more", name="flocks_list_ajax")
     * @Extra\Template("FlockMainBundle:Flock:_list_more.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return void
     */
    public function ajaxListAction(Request $request)
    {
        $limit = 10;
        if (!$offset = $request->get('offset')) {
            return new Response("Oops! That's weird!");
        }

        $flocks = $this->getDoctrine()->getRepository('FlockMainBundle:Flock')->getActiveFlocks($limit, $offset);
        $flocksCounts = $this->getDoctrine()->getRepository('FlockMainBundle:Flock')->getActiveFlocksCount();

        return array(
            'flocks' => $flocks,
            'offset' => $offset + $limit,
            'showLoadMore' => $flocksCounts > $offset + $limit ? true : false,
        );
    }

    /**
     * @Extra\Route("/list", name="flocks_list")
     * @Extra\Template("FlockMainBundle:Flock:list.html.twig")
     *
     * @return array
     */
    public function listAction()
    {
        $limit = 10;
        $offset = 0;

        $flocks = $this->getDoctrine()->getRepository('FlockMainBundle:Flock')->getActiveFlocks($limit, $offset);
        $flocksCounts = $this->getDoctrine()->getRepository('FlockMainBundle:Flock')->getActiveFlocksCount();

        return array(
            'flocks' => $flocks,
            'offset' => $offset + $limit,
            'showLoadMore' => $flocksCounts > $offset + $limit ? true : false,
        );
    }

    /**
     * @Extra\Route("/myFlocks", name="my_flocks")
     * @Extra\Template("FlockMainBundle:Flock:my_flocks.html.twig")
     *
     * @return array
     */
    public function myFlocksAction()
    {
//        $flocksCreated = $this->get('security.context')->getToken()->getUser()->getFlocksCreated();
//        $flocksAttending = $this->get('security.context')->getToken()->getUser()->getFlocksAttending();

        return array(
//            'flocksCreated' => $flocksCreated,
//            'flocksAttending' => $flocksAttending,
        );
    }

    /**
     * @Extra\Route("/{id}", name="flock_show")
     * @Extra\ParamConverter("flock", class="FlockMainBundle:Flock")
     * @Extra\Template("FlockMainBundle:Flock:show.html.twig")
     *
     * @param \Flock\MainBundle\Entity\Flock $flock
     * @return array
     */
    public function showAction(Flock $flock)
    {
        $defaultTweet = "Join me for ".$flock->getName();
        if ($flock->getHashTag()) {
            $defaultTweet .= " ".$flock->getHashTag();
        }
        if (strlen($defaultTweet) > 140) {
            $diff = strlen($defaultTweet) - 140;
            $refactoredName = substr($flock->getName(), 0, strlen($defaultTweet) - $diff - 3).'...';
            $defaultTweet = "Join me for ".$refactoredName;
            if ($flock->getHashTag()) {
                $defaultTweet .= " ".$flock->getHashTag();
            }
        }

        $isAttending = false;
        $user = $this->get('security.context')->getToken()->getUser();
        if ($user instanceof User) {
            if ($this->getDoctrine()->getRepository('FlockMainBundle:Attendee')->findOneBy(array('flock' => $flock, 'user' => $user->getId()))) {
                $isAttending = true;
            }
        }

        $attendees = $this->getDoctrine()->getRepository('FlockMainBundle:Attendee')->findBy(array('flock' => $flock),array(),10,0);
        $attendeeCount = $this->getDoctrine()->getRepository('FlockMainBundle:Attendee')->getAttendeeCount($flock);

        return array(
            'flock' => $flock,
            'isAttending' => $isAttending,
            'defaultTweet' => $defaultTweet,
            'attendees' => $attendees,
            'attendeeCount' => $attendeeCount,
        );
    }

    /**
     * @Extra\Route("/{id}/edit", name="flock_edit")
     * @Extra\ParamConverter("flock", class="FlockMainBundle:Flock")
     * @Extra\Template("FlockMainBundle:Flock:show.html.twig")
     *
     * @param \Flock\MainBundle\Entity\Flock $flock
     * @return array
     */
    public function editAction(Flock $flock)
    {
        //TODO: proceed only if Flock creator is the session user
        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->get('doctrine')->getEntityManager();
        $form = $this->buildForm($flock);

        if ($this->get('request')->getMethod() === 'POST') {
            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {
                $em->persist($flock);
                $em->flush();

                return new RedirectResponse($this->generateUrl('flock_create'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Extra\Route("/{id}/toggleJoin", name="flock_toggle_join")
     * @Extra\ParamConverter("flock", class="FlockMainBundle:Flock")
     *
     * @param \Flock\MainBundle\Entity\Flock $flock
     * @return array
     */
    public function toggleJoinAction(Flock $flock)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $this->getDoctrine()->getRepository('FlockMainBundle:Attendee')->addOrRemoveAttendee($flock, $user);

        return new RedirectResponse($this->generateUrl('flock_show',array('id' => $flock)));
    }

    /**
     * @Extra\Route("/{id}/attendees", name="flock_attendees")
     * @Extra\ParamConverter("flock", class="FlockMainBundle:Flock")
     * @Extra\Template("FlockMainBundle:Flock:_attendees.html.twig")
     *
     * @param \Flock\MainBundle\Entity\Flock $flock
     * @return array
     */
    public function getAttendeesAction(Flock $flock)
    {
        $attendees = $flock->getAttendees();

        return array('attendees' => $attendees);
    }

    private function buildForm(Flock $flock)
    {
        $factory = $this->get('form.factory');
        $form = $factory->create(new FlockForm());
        $form->setData($flock);

        return $form;
    }
}

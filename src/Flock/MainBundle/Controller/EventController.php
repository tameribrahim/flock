<?php
/**
 * Created by Amal Raghav <amal.raghav@gmail.com>
 * Date: 07/05/11
 */

namespace Flock\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Flock\MainBundle\Form\EventForm;
use Flock\MainBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;


/**
 * @Extra\Route("/event")
 */
class EventController extends Controller
{
    /**
     * @Extra\Route("/create", name="flock_create")
     * @Extra\Template("FlockMainBundle:Event:create.html.twig")
     */
    public function createAction()
    {
        $em = $this->get('doctrine')->getEntityManager();
        $event = new Event();
        $form = $this->buildForm($event);

        if ($this->get('request')->getMethod() === 'POST') {
            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {
                $em->persist($event);
                $em->flush();

                return new RedirectResponse($this->generateUrl('flock_create'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Extra\Route("/{id}", name="flock_event")
     * @Extra\ParamConverter("event", class="FlockMainBundle:Event")
     * @Extra\Template("FlockMainBundle:Event:show.html.twig")
     */
    public function showAction(Event $event)
    {
        return array('event' => $event);
    }

    protected function buildForm(Event $event)
    {
        $factory = $this->get('form.factory');
        $form = $factory->create(new EventForm());
        $form->setData($event);

        return $form;
    }
}

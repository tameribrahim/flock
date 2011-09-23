<?php
/**
 * Created by Amal Raghav <amal.raghav@gmail.com>
 * Date: 07/05/11
 */

namespace Flock\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Flock\MainBundle\Entity\Flock;
use Flock\MainBundle\Form\FlockForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

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
     * @Extra\Route("/{id}", name="flock_show")
     * @Extra\ParamConverter("flock", class="FlockMainBundle:Flock")
     * @Extra\Template("FlockMainBundle:Flock:show.html.twig")
     *
     * @param \Flock\MainBundle\Entity\Flock $flock
     * @return array
     */
    public function showAction(Flock $flock)
    {
        return array('flock' => $flock);
    }

    /**
     * @Extra\Route("/edit/{id}", name="flock_edit")
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

    private function buildForm(Flock $flock)
    {
        $factory = $this->get('form.factory');
        $form = $factory->create(new FlockForm());
        $form->setData($flock);

        return $form;
    }
}

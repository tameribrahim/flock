<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 17/04/11
 */

namespace Flock\MainBundle\Form;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;

class EventForm extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('event_name', null, array('label' => 'What\'s the event?'))
            ->add('event_details', null, array('label' => 'Share more details?'))
            ->add('event_start', null, array('label' => 'Starting date and time', 'date_pattern' => "{{ month }}&nbsp;{{ day }}&nbsp;{{ year }}"))
            ->add('event_end', null, array('label' => 'Ending date and time', 'date_pattern' => "{{ month }}&nbsp;{{ day }}&nbsp;{{ year }}"))
            ->add('website', 'url', array('label' => 'Got a website?'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Flock\MainBundle\Entity\Event',
        );
    }

    public function getName()
    {
        return 'event_form';
    }
}

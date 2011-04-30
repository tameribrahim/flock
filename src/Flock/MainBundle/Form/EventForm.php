<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 17/04/11
 */

namespace Flock\MainBundle\Form;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;
use \IntlDateFormatter;

class EventForm extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('event_name', null, array('label' => 'Event name'))
            ->add('event_details', null, array('label' => 'More info?'))
            ->add('event_start', null, array('label' => 'From', 'date_widget' => 'text', 'date_format' => IntlDateFormatter::FULL))
            ->add('event_end', null, array('label' => 'until', 'date_widget' => 'text', 'date_format' => IntlDateFormatter::FULL))
            ->add('website', null, array('label' => 'Got a website?'))
            ->add('place', null, array('label' => 'Place'))
            ->add('address', null, array('label' => 'Address'))
            ->add('lat', 'hidden')
            ->add('lng', 'hidden');
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

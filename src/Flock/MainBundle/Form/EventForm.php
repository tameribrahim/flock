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
            ->add('name', null, array('label' => 'In one line'))
            ->add('details', null, array('label' => 'Detailed'))
            ->add('starts_at', null, array(
                'label' => 'From',
                'date_format' => IntlDateFormatter::FULL,
                'years' => array(date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3, date('Y') + 4, date('Y') + 5),
             ))
            ->add('ends_at', null, array(
              'label' => 'To',
              'date_format' => IntlDateFormatter::FULL,
              'years' => array(date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3, date('Y') + 4, date('Y') + 5),
             ))
            ->add('website', null, array('label' => 'Got a website?'))
            ->add('place', null, array('label' => 'Place'))
            ->add('address', null, array('label' => 'Address'))
            ->add('lat', 'hidden')
            ->add('lng', 'hidden')
            ->add('zoom', 'hidden');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Flock\MainBundle\Entity\Event',
        );
    }

    public function getName()
    {
        return 'event';
    }
}

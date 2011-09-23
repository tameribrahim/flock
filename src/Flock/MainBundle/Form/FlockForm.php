<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 17/04/11
 */

namespace Flock\MainBundle\Form;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;
use \IntlDateFormatter;

class FlockForm extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'What is it?'))
            ->add('startsAt', null, array(
                'label' => '',
                'date_format' => 'MM/dd/yyyy',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
             ))
            ->add('endsAt', null, array(
                'label' => '',
                'date_format' => 'MM/dd/yyyy',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
             ))
            ->add('hashTag', null, array('label' => 'Twitter Hashtag'))
            ->add('website', null, array('label' => 'Website'))
            ->add('place', null, array('label' => 'Where is it?'))
            ->add('lat', 'hidden')
            ->add('lng', 'hidden')
            ->add('zoom', 'hidden');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Flock\MainBundle\Entity\Flock',
        );
    }

    public function getName()
    {
        return 'flock';
    }
}

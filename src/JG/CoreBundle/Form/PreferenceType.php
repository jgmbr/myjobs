<?php

namespace JG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreferenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('showCompanies', CheckboxType::class, array('label' => 'Rubrique Entreprises','required' => false))
            ->add('showApplications', CheckboxType::class, array('label' => 'Rubrique Applications','required' => false))
            ->add('showAppointments', CheckboxType::class, array('label' => 'Rubrique Entretiens','required' => false))
            ->add('showStatistics', CheckboxType::class, array('label' => 'Rubrique Statistiqtues','required' => false))
            ->add('pushAlerts', CheckboxType::class, array('label' => 'Notifications Alertes','required' => false))
            ->add('delayAlerts', ChoiceType::class, array('label' => 'Délai Alertes (jours)',

                'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                )
            ,'required' => false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JG\CoreBundle\Entity\Preference',
            'current_user' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jg_corebundle_preference';
    }


}

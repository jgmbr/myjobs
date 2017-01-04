<?php

namespace JG\CoreBundle\Form;

use JG\CoreBundle\Repository\ApplicationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['current_user'];

        $builder
            ->add('application', EntityType::class, array(
                'label'         => 'Candidature',
                'class'         => 'JGCoreBundle:Application',
                'choice_label'  => 'fullname',
                'multiple'      => false,
                'query_builder' => function(ApplicationRepository $repository) use($user) {
                    return $repository->myApplicationsFromQB($user);
                }
            ))
            ->add('name', TextType::class, array('label' => 'Nom'))
            ->add('state', EntityType::class, array(
                'label'         => 'Etat',
                'class'         => 'JGCoreBundle:State',
                'choice_label'  => 'name',
                'multiple'      => false,
            ))
            ->add('dateAt', DateType::class, array(
                'label'     => 'Date',
                'widget'    => 'single_text',
            ))
            ->add('hourAt', TimeType::class, array(
                'label'     => 'Heure',
                'widget'    => 'single_text',
            ))
            ->add('comment', TextareaType::class, array('label' => 'Commentaire(s)', 'required' => false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JG\CoreBundle\Entity\Appointment',
            'current_user' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jg_corebundle_appointment';
    }


}

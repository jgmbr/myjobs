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
            ->add('showCompanies', CheckboxType::class, array(
                'label' => 'Afficher la rubrique Entreprises sur le tableau de bord',
                'required'      => false,
                'translation_domain' => false,
            ))
            ->add('showApplications', CheckboxType::class, array(
                'label' => 'Afficher la rubrique Candidatures sur le tableau de bord',
                'required'      => false,
                'translation_domain' => false,
            ))
            ->add('showAppointments', CheckboxType::class, array(
                'label' => 'Afficher la rubrique Entretiens sur le tableau de bord',
                'required'      => false,
                'translation_domain' => false,
            ))
            ->add('showStatistics', CheckboxType::class, array(
                'label' => 'Afficher la rubrique Statistiques sur le tableau de bord',
                'required'      => false,
                'translation_domain' => false,
            ))
            ->add('pushAlerts', CheckboxType::class, array(
                'label' => 'Recevoir des notifications dans la rubrique "Mes Alertes"',
                'required'      => false,
                'translation_domain' => false,
            ))
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

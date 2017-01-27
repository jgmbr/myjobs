<?php

namespace JG\CoreBundle\Form;

use JG\CoreBundle\Form\Type\StepType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class DownloadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('help1', StepType::class, array(
                'label' => false,
                'number' => 1,
                'title' => 'Je souhaite exporter sur une période donnée'
            ))
            ->add('start', DateType::class, array(
                'label' => 'Période début *',
                'widget'    => 'single_text',
                'required' => true,
                'data' => new \DateTime('first day of this month')
            ))
            ->add('end', DateType::class, array(
                'label' => 'Période fin *',
                'widget'    => 'single_text',
                'required' => true,
                'data' => new \DateTime('last day of this month')
            ))
            ->add('help2', StepType::class, array(
                'label' => false,
                'number' => 2,
                'title' => 'Je souhaite exporter toutes les données'
            ))
            ->add('init', ChoiceType::class, array(
                'label' => false,
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'choices' => array(
                    'Oui' => true,
                ),
            ))
            ->add('help3', StepType::class, array(
                'label' => false,
                'number' => 3,
                'title' => 'Je souhaite exporter les données suivantes :'
            ))
            ->add('type', ChoiceType::class, array(
                'label' => 'Type(s) de données *',
                'required' => true,
                'multiple' => true,
                'expanded' => true,
                'choices' => array(
                    'Candidatures' => 'application',
                    'Entreprises' => 'company',
                    'Entretiens' => 'appointment'
                ),
                'constraints' => array(
                    new NotNull(array(
                        'message' => 'Veuillez sélectionner un type de données'
                    )),
                    new NotBlank(array(
                        'message' => 'Veuillez sélectionner un type de données'
                    ))
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jg_corebundle_download';
    }


}

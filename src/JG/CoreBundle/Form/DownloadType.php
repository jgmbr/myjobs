<?php

namespace JG\CoreBundle\Form;

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
            ->add('start', DateType::class, array(
                'label' => 'Période début *',
                'required' => true,
                'data' => new \DateTime('first day of this month')
            ))
            ->add('end', DateType::class, array(
                'label' => 'Période fin *',
                'required' => true,
                'data' => new \DateTime('last day of this month')
            ))
            ->add('init', ChoiceType::class, array(
                'label' => 'Depuis le début',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'choices' => array(
                    'Oui' => true,
                ),
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

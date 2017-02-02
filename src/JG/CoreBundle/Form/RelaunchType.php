<?php

namespace JG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelaunchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['current_user'];

        $builder
            ->add('dateAt', DateType::class, array(
                'label'     => 'Date',
                'widget'    => 'single_text',
                'data'      => new \DateTime("now"),
                'required'  => true,
                'translation_domain' => false,
            ))
            ->add('hourAt', TimeType::class, array(
                'label'     => 'Heure',
                'widget'    => 'single_text',
                'data'      => new \DateTime("now"),
                'required'  => true,
                'translation_domain' => false,
            ))
            ->add('comment', TextareaType::class, array(
                'label'     => 'Commentaire',
                'required'  => false,
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
            'data_class' => 'JG\CoreBundle\Entity\Relaunch',
            'current_user' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jg_corebundle_relaunch';
    }


}

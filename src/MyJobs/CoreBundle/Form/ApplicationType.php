<?php

namespace MyJobs\CoreBundle\Form;

use MyJobs\CoreBundle\Repository\CompanyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom'))
            ->add('url', TextType::class, array('label' => 'Url de l\'annonce'))
            ->add('comment', TextareaType::class, array('label' => 'Commentaire'))
            ->add('contract', EntityType::class, array(
                'label' => 'Contrat',
                'class'        => 'MyJobsCoreBundle:Contract',
                'choice_label' => 'name',
                'multiple'     => false,
            ))
            ->add('status', EntityType::class, array(
                'label' => 'Statut',
                'class'        => 'MyJobsCoreBundle:Status',
                'choice_label' => 'name',
                'multiple'     => false,
            ))
            ->add('company', EntityType::class, array(
                'label' => 'Entreprise',
                'class'        => 'MyJobsCoreBundle:Company',
                'choice_label' => 'name',
                'multiple'     => false,
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyJobs\CoreBundle\Entity\Application'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myjobs_corebundle_application';
    }


}

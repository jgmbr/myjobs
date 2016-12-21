<?php

namespace MyJobs\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom'))
            ->add('address1', TextType::class, array('label' => 'Adresse'))
            ->add('address2', TextType::class, array('label' => 'Complément d\'adresse', 'required' => false))
            ->add('postcode', TextType::class, array('label' => 'Code postal'))
            ->add('city', TextType::class, array('label' => 'Ville'))
            ->add('country', CountryType::class, array('label' => 'Pays'))
            ->add('email', EmailType::class, array('label' => 'Email'))
            ->add('phone', TextType::class, array('label' => 'Téléphone'))
            ->add('website', TextType::class, array('label' => 'Site web'))
            ->add('contact', TextType::class, array('label' => 'Contact'))
            ->add('comment', TextareaType::class, array('label' => 'Commentaire', 'required' => false))
            //->add('createdAt')
            //->add('updatedAt')
            //->add('user')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyJobs\CoreBundle\Entity\Company'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myjobs_corebundle_company';
    }


}

<?php

namespace JG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class CompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom *',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Nom obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Nom obligatoire'
                    ))
                )
            ))
            ->add('address1', TextType::class, array(
                'label' => 'Adresse',
                'required' => false
            ))
            ->add('address2', TextType::class, array(
                'label' => 'Complément d\'adresse',
                'required' => false
            ))
            ->add('postcode', TextType::class, array(
                'label' => 'Code postal',
                'required' => false,
                'constraints' => array(
                    new Length(array(
                        'min' => 5,
                        'max' => 5,
                    )),
                )
            ))
            ->add('city', TextType::class, array(
                'label' => 'Ville',
                'required' => false
            ))
            ->add('country', CountryType::class, array(
                'label' => 'Pays',
                'required' => false,
                'data' => 'FR'
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'required' => false
            ))
            ->add('phone', TextType::class, array(
                'label' => 'Téléphone',
                'required' => false
            ))
            ->add('website', TextType::class, array(
                'label' => 'Site web',
                'required' => false
            ))
            ->add('contact', TextType::class, array(
                'label' => 'Contact',
                'required' => false
            ))
            ->add('comment', TextareaType::class, array(
                'label' => 'Commentaire',
                'required' => false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JG\CoreBundle\Entity\Company'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jg_corebundle_company';
    }


}

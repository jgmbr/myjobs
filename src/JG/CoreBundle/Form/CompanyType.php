<?php

namespace JG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EmailValidator;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

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
                'required'      => true,
                'translation_domain' => false,
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
                'required'      => false,
                'translation_domain' => false,
            ))
            ->add('address2', TextType::class, array(
                'label' => 'Complément d\'adresse',
                'required'      => false,
                'translation_domain' => false,
            ))
            ->add('postcode', TextType::class, array(
                'label' => 'Code postal',
                'required'      => false,
                'translation_domain' => false,
                'constraints' => array(
                    new Length(array(
                        'min' => 5,
                        'max' => 5,
                    )),
                )
            ))
            ->add('city', TextType::class, array(
                'label' => 'Ville',
                'required'      => false,
                'translation_domain' => false,
            ))
            ->add('country', CountryType::class, array(
                'label' => 'Pays',
                'required'      => false,
                'translation_domain' => false,
                'data' => 'FR'
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'required'      => false,
                'translation_domain' => false,
                'constraints' => array(
                    new Email(array(
                        'message' => 'Adresse email incorrecte'
                    ))
                )
            ))
            ->add('phone', TextType::class, array(
                'label' => 'Téléphone',
                'required'      => false,
                'translation_domain' => false,
                'constraints' => array(
                    new Length(array(
                        'min' => 10,
                        'minMessage' => 'Nombre de caractères minimal requis 10',
                        'max' => 10,
                        'maxMessage' => 'Nombre de caractères maximal requis 10',
                    )),
                    new Regex(array(
                        'pattern' => '^0[0-9]([-. ]?\d{2}){4}[-. ]?$^',
                        'message' => 'Format numéro de mobile incorrect'
                    ))
                )
            ))
            ->add('website', TextType::class, array(
                'label' => 'Site web',
                'required'      => false,
                'translation_domain' => false,
                'constraints' => array(
                    new Url(array(
                        'message' => 'Adresse site web incorrecte'
                    ))
                )
            ))
            ->add('contact', TextType::class, array(
                'label' => 'Contact',
                'required'      => false,
                'translation_domain' => false,
            ))
            ->add('comment', TextareaType::class, array(
                'label' => 'Commentaire',
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

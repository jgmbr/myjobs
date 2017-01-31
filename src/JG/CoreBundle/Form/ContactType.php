<?php

namespace JG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom',
                'attr' => array(
                    'placeholder' => 'Votre prénom',
                ),
                'required' => true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new Length(array(
                        'min' => 3,
                        'minMessage' => 'Nombre de caractères minimal requis {{ limit }}',
                        'max' => 255,
                        'maxMessage' => 'Nombre de caractères minimal requis {{ limit }}'
                    ))
                )
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Nom',
                'attr' => array(
                    'placeholder' => 'Votre nom',
                ),
                'required' => true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new Length(array(
                        'min' => 3,
                        'minMessage' => 'Nombre de caractères minimal requis {{ limit }}',
                        'max' => 255,
                        'maxMessage' => 'Nombre de caractères minimal requis {{ limit }}'
                    ))
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Adresse email',
                'attr' => array(
                    'placeholder' => 'Votre adresse email',
                ),
                'required' => true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new Length(array(
                        'min' => 3,
                        'minMessage' => 'Nombre de caractères minimal requis {{ limit }}',
                        'max' => 255,
                        'maxMessage' => 'Nombre de caractères minimal requis {{ limit }}'
                    )),
                    new Email(array(
                        'message' => 'Format adresse email incorrect'
                    ))
                )
            ))
            ->add('subject', TextType::class, array(
                'label' => 'Objet',
                'attr' => array(
                    'placeholder' => 'Sujet de votre message',
                ),
                'required' => true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new Length(array(
                        'min' => 10,
                        'minMessage' => 'Nombre de caractères minimal requis {{ limit }}',
                        'max' => 255,
                        'maxMessage' => 'Nombre de caractères minimal requis {{ limit }}'
                    ))
                )
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Message',
                'attr' => array(
                    'placeholder' => 'Votre message',
                    'rows' => 8
                ),
                'required' => true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new Length(array(
                        'min' => 50,
                        'minMessage' => 'Nombre de caractères minimal requis {{ limit }}'
                    ))
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JG\CoreBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jg_corebundle_contact';
    }


}

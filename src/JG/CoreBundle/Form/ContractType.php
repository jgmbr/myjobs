<?php

namespace JG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ContractType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Nom obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Nom obligatoire'
                    )),
                )
            ))
            ->add('color', TextType::class, array(
                'label' => 'Code couleur',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Code couleur obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Code couleur obligatoire'
                    )),
                    new Length(array(
                        'min' => 7,
                        'max' => 7,
                        'exactMessage' => 'Code couleur doit contenir 7 caractères (ex : #ffffff)'
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
            'data_class' => 'JG\CoreBundle\Entity\Contract'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jg_corebundle_contract';
    }


}

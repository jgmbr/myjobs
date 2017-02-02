<?php

namespace JG\CoreBundle\Form;

use JG\CoreBundle\Repository\CompanyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\UrlValidator;

class ApplicationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['current_user'];

        $builder
            ->add('dateAt', DateType::class, array(
                'label'     => 'Date *',
                'required' => true,
                'widget'    => 'single_text',
                'translation_domain' => false,
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom *',
                'required' => true,
                'translation_domain' => false,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Champ obligatoire'
                    )),
                    new NotNull(array(
                        'message' => 'Champ obligatoire'
                    ))
                )
            ))
            ->add('url', TextType::class, array(
                'label' => 'Url de l\'annonce',
                'translation_domain' => false,
                'required' => false,
                'constraints' => array(
                    new Url(array(
                        'message' => 'Url incorrecte'
                    ))
                )
            ))
            ->add('contract', EntityType::class, array(
                'label'         => 'Contrat',
                'required'      => true,
                'translation_domain' => false,
                'class'         => 'JGCoreBundle:Contract',
                'choice_label'  => 'name',
                'multiple'      => false,
            ))
            ->add('status', EntityType::class, array(
                'label'         => 'Statut',
                'required'      => true,
                'translation_domain' => false,
                'class'         => 'JGCoreBundle:Status',
                'choice_label'  => 'name',
                'multiple'      => false,
            ))
            ->add('company', EntityType::class, array(
                'label'         => 'Entreprise',
                'required'      => true,
                'translation_domain' => false,
                'class'         => 'JGCoreBundle:Company',
                'choice_label'  => 'name',
                'multiple'      => false,
                'query_builder' => function(CompanyRepository $repository) use($user) {
                    return $repository->myCompaniesFromQB($user);
                }
            ))
            ->add('businessReason', TextareaType::class, array(
                'label' => 'Motif Entreprise',
                'required' => false,
                'translation_domain' => false,
            ))
            ->add('peopleReason', TextareaType::class, array(
                'label' => 'Motif Candidat',
                'required' => false,
                'translation_domain' => false,
            ))
            ->add('comment', TextareaType::class, array(
                'label' => 'Commentaires',
                'required' => false,
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
            'data_class' => 'JG\CoreBundle\Entity\Application',
            'current_user' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jg_corebundle_application';
    }


}

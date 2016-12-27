<?php

namespace MyJobs\CoreBundle\Form;

use MyJobs\CoreBundle\Repository\CompanyRepository;
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
                'label'     => 'Date',
                'widget'    => 'single_text',
            ))
            ->add('name', TextType::class, array('label' => 'Nom'))
            ->add('url', TextType::class, array('label' => 'Url de l\'annonce', 'required' => false))
            ->add('contract', EntityType::class, array(
                'label'         => 'Contrat',
                'class'         => 'MyJobsCoreBundle:Contract',
                'choice_label'  => 'name',
                'multiple'      => false,
            ))
            ->add('status', EntityType::class, array(
                'label'         => 'Statut',
                'class'         => 'MyJobsCoreBundle:Status',
                'choice_label'  => 'name',
                'multiple'      => false,
            ))
            ->add('company', EntityType::class, array(
                'label'         => 'Entreprise',
                'class'         => 'MyJobsCoreBundle:Company',
                'choice_label'  => 'name',
                'multiple'      => false,
                'query_builder' => function(CompanyRepository $repository) use($user) {
                    return $repository->myCompaniesFromQB($user);
                }
            ))
            ->add('businessReason', TextareaType::class, array('label' => 'Motif entreprise', 'required' => false))
            ->add('peopleReason', TextareaType::class, array('label' => 'Motif candidat', 'required' => false))
            ->add('comment', TextareaType::class, array('label' => 'Commentaires', 'required' => false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyJobs\CoreBundle\Entity\Application',
            'current_user' => null
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

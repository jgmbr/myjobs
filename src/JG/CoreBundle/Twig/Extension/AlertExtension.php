<?php

namespace JG\CoreBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AlertExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $doctrine;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(ContainerInterface $container, TokenStorageInterface $tokenStorage)
    {
        $this->doctrine     = $container->get('doctrine');
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'nbAlerts'   => new \Twig_Function_Method($this, 'nbAlerts')
        );
    }

    public function nbAlerts()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'alert_extension';
    }
}

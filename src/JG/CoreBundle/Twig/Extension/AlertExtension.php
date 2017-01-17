<?php

namespace JG\CoreBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AlertExtension extends \Twig_Extension
{
    private $doctrine;
    private $token;

    public function __construct(ContainerInterface $container, TokenStorageInterface $tokenStorage)
    {
        $this->doctrine = $container->get('doctrine');
        $this->token = $tokenStorage;
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
        $user = $this->token->getToken()->getUser();

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

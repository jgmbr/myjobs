<?php

namespace JG\CoreBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CounterExtension extends \Twig_Extension
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
            'nbAlerts'          => new \Twig_Function_Method($this, 'nbAlerts'),
            'nbApplications'    => new \Twig_Function_Method($this, 'nbApplications'),
            'nbCompanies'       => new \Twig_Function_Method($this, 'nbCompanies'),
            'nbAppointments'    => new \Twig_Function_Method($this, 'nbAppointments'),
            'nbContracts'       => new \Twig_Function_Method($this, 'nbContracts'),
            'nbStatus'          => new \Twig_Function_Method($this, 'nbStatus'),
            'nbStates'          => new \Twig_Function_Method($this, 'nbStates'),
            'nbAllCompanies'    => new \Twig_Function_Method($this, 'nbAllCompanies'),
            'nbAllApplications' => new \Twig_Function_Method($this, 'nbAllApplications'),
            'nbAllUsers'        => new \Twig_Function_Method($this, 'nbAllUsers'),
            'nbContacts'        => new \Twig_Function_Method($this, 'nbContacts'),
        );
    }

    // Account

    public function nbAlerts()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->doctrine->getRepository('JGCoreBundle:Alert')->countMyAlerts($user);
    }

    public function nbApplications()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->doctrine->getRepository('JGCoreBundle:Application')->countMyApplications($user);
    }

    public function nbCompanies()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->doctrine->getRepository('JGCoreBundle:Company')->countMyCompanies($user);
    }

    public function nbAppointments()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->doctrine->getRepository('JGCoreBundle:Appointment')->countMyAppointments($user);
    }

    // Admin

    public function nbContracts()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->doctrine->getRepository('JGCoreBundle:Contract')->findCount();
    }

    public function nbStatus()
    {
        $user = $this->tokenStorage->getToken()->getUser();


        return $this->doctrine->getRepository('JGCoreBundle:Status')->findCount();
    }

    public function nbStates()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->doctrine->getRepository('JGCoreBundle:State')->findCount();
    }

    public function nbAllCompanies()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->doctrine->getRepository('JGCoreBundle:Company')->findCount();
    }

    public function nbAllApplications()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->doctrine->getRepository('JGCoreBundle:Application')->findCount();
    }

    public function nbAllUsers()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->doctrine->getRepository('JGUserBundle:User')->findCount();
    }

    public function nbContacts()
    {
        return $this->doctrine->getRepository('JGCoreBundle:Contact')->countUnread();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'alert_extension';
    }
}

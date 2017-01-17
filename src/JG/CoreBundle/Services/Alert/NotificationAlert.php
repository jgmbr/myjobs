<?php

namespace JG\CoreBundle\Services\Alert;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NotificationAlert
{
    /**
    * @var EntityManagerInterface
    */
    private $em;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    // On injecte l'EntityManager
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em             = $em;
        $this->tokenStorage   = $tokenStorage;
    }

    public function alert($days)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($days > 0) {

            $date = new \Datetime($days.' days ago');

            $listApplications = $this->em->getRepository('JGCoreBundle:Application')->getApplicationsAfterDelay($date);

            foreach ($listApplications as $application) {
                $alert = new Alert();
                $alert->setName('Relance');
                $alert->setContent(
                    'N\'oubliez pas de relancer la candidature '
                    .$application->getName().' - '
                    .$application->getCompany()->getName()
                );
                $alert->setDateAt(new \Datetime());
                $alert->setUser($user);
                $user->addAlert($alert);
                $this->em->persist($alert);
            }

            $this->em->flush();

        }
    }
}

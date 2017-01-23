<?php

namespace JG\CoreBundle\Services\Alert;

use Doctrine\ORM\EntityManagerInterface;
use JG\CoreBundle\Entity\Alert;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ApplicationAlert
{
    /**
    * @var EntityManagerInterface
    */
    private $em;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em             = $em;
        $this->tokenStorage   = $tokenStorage;
    }

    public function alert()
    {
        $listUsers = $this->em->getRepository('JGUserBundle:User')->findAllUsers();

        foreach($listUsers as $user) {

            if (sizeof($user->getPreferences()) > 0) {

                foreach($user->getPreferences() as $preference) {

                    $pushAlerts = $preference->getPushAlerts();

                    $delayAlerts = $preference->getDelayAlerts();

                    if ($pushAlerts && $delayAlerts > 0) {

                        $date = new \Datetime($delayAlerts . ' days ago');

                        $listApplications = $this->em->getRepository('JGCoreBundle:Application')->getApplicationsAfterDelay($user, $date);

                        if (sizeof($listApplications) > 0) {

                            foreach($listApplications as $application) {

                                $alert = new Alert();
                                $alert->setName('Relance');
                                $alert->setContent("N'oubliez pas de relancer la candidature");
                                $alert->setDateAt(new \DateTime());
                                $alert->setViewed(false);
                                $alert->setUser($user);
                                $alert->setApplication($application);
                                $application->addAlert($alert);
                                //$user->addAlert($alert);
                                $this->em->persist($alert);

                            }

                            $this->em->flush();

                        } else {

                            var_dump('no applications');

                        }

                    }

                }

            }

        }

    }
}

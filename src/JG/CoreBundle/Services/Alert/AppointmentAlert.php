<?php

namespace JG\CoreBundle\Services\Alert;

use Doctrine\ORM\EntityManagerInterface;
use JG\CoreBundle\Entity\Alert;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AppointmentAlert
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

            if (sizeof($user->getPreferences()) > 0 && sizeof($user->getAppointments()) > 0) {

                foreach ($user->getPreferences() as $preference) {

                    if ($preference->getPushAlerts()) {

                        foreach($user->getAppointments() as $appointment) {

                            $today = new \DateTime('now');

                            if ($appointment->getDateAt()->format('d/m/Y') == $today->format('d/m/Y')) {

                                $alert = new Alert();
                                $alert->setName('Entretien');
                                $alert->setContent("N'oubliez pas votre entretien");
                                $alert->setDateAt(new \DateTime());
                                $alert->setViewed(false);
                                $alert->setUser($user);
                                $alert->setAppointment($appointment);
                                $appointment->addAlert($alert);
                                $this->em->persist($alert);
                                $this->em->flush();

                            }

                        }

                    }

                }

            }

        }

    }
}

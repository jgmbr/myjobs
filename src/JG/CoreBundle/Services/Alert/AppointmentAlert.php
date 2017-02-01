<?php

namespace JG\CoreBundle\Services\Alert;

use Doctrine\ORM\EntityManagerInterface;
use JG\CoreBundle\Entity\Alert;
use JG\CoreBundle\Entity\Appointment;
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
        $today = new \DateTime('now');

        $date = $today->format('Y-m-d');

        // Get all appointments for today
        $listAppointments = $this->em->getRepository('JGCoreBundle:Appointment')->findByDateAt(new \DateTime($date));

        if (sizeof($listAppointments) > 0) {

            foreach ($listAppointments as $appointment) {

                $application    = $appointment->getApplication();
                $user           = $appointment->getUser();

                foreach ($user->getPreferences() as $preference)
                {
                    $pushAlert = $preference->getPushAlerts();

                    if ($pushAlert) {

                        // Check if alert day already exists
                        $isAlert = $this->em->getRepository('JGCoreBundle:Alert')->findBy(array(
                            'appointment' => $appointment,
                            'user' => $user,
                            'application' => $application,
                            'dateAt' => new \DateTime($date)
                        ));

                        if (!sizeof($isAlert)) {

                            $alert = new Alert();
                            $alert->setName('Entretien');
                            $alert->setContent("N'oubliez pas votre entretien d'aujourd'hui");
                            $alert->setDateAt(new \DateTime($date));
                            $alert->setViewed(false);
                            $alert->setUser($user);
                            $alert->setAppointment($appointment);
                            $alert->setApplication($application);
                            $appointment->addAlert($alert);
                            $application->addAlert($alert);
                            $this->em->persist($alert);
                            $this->em->flush($alert);

                        }

                    }
                }

            }

        }

    }
}

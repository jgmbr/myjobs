<?php

namespace JG\CoreBundle\Services\Crud;

use Doctrine\ORM\EntityManagerInterface;
use JG\CoreBundle\Entity\Application;
use JG\CoreBundle\Entity\Appointment;
use JG\CoreBundle\Entity\Company;
use JG\CoreBundle\Entity\EntityInterface\ExportInterface;
use JG\CoreBundle\Entity\Relaunch;
use JG\UserBundle\Entity\User;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DeleteDatas
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function deleteApplication(Application $application, User $user, $andFlush = true)
    {
        if (!$application instanceof Application)
            throw new NotFoundHttpException('Candidature non reconnue');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $user->removeApplication($application);

        $this->em->remove($application);

        if ($andFlush)
            $this->em->flush();

        return true;
    }

    public function deleteAppointment(Appointment $appointment, User $user, $andFlush = true)
    {
        if (!$appointment instanceof Appointment)
            throw new NotFoundHttpException('Entretien non reconnu');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $user->removeAppointment($appointment);

        $appointment->getApplication()->removeAppointment($appointment);

        $this->em->persist($appointment);

        if ($andFlush)
            $this->em->flush($appointment);

        return true;
    }

    public function deleteCompany(Company $company, User $user, $andFlush = true)
    {
        if (!$company instanceof Company)
            throw new NotFoundHttpException('Entreprise non reconnue');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $user->removeCompany($company);

        $this->em->remove($company);

        if ($andFlush)
            $this->em->flush($company);

        return true;
    }

    public function deleteRelaunch(Relaunch $relaunch, User $user, $andFlush = true)
    {
        if (!$relaunch instanceof Relaunch)
            throw new NotFoundHttpException('Relance non reconnue');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $relaunch->getApplication()->removeRelaunch($relaunch);

        $this->em->remove($relaunch);

        if ($andFlush)
            $this->em->flush($relaunch);

        return true;
    }

    public function deleteEntity($entity, $andFlush = true)
    {
        if (!is_object($entity))
            throw new NotFoundHttpException('Entité non reconnue');

        $this->em->remove($entity);

        if ($andFlush)
            $this->em->flush($entity);

        return true;
    }

}

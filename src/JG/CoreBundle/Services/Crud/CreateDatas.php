<?php

namespace JG\CoreBundle\Services\Crud;

use Doctrine\ORM\EntityManagerInterface;
use JG\CoreBundle\Entity\Application;
use JG\CoreBundle\Entity\Appointment;
use JG\CoreBundle\Entity\Company;
use JG\CoreBundle\Entity\EntityInterface\ExportInterface;
use JG\CoreBundle\Entity\Preference;
use JG\CoreBundle\Entity\Relaunch;
use JG\UserBundle\Entity\User;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateDatas
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createEntity($entity, $andFlush = true)
    {
        if (!is_object($entity))
            throw new NotFoundHttpException('Entité non reconnue');

        $this->em->persist($entity);

        if ($andFlush)
            $this->em->flush();

        return true;
    }

    public function createUser(User $user, $andFlush = true)
    {
        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $exist = $this->em->getRepository(User::class)->findOneByEmail($user->getEmail());

        if (is_object($exist)) {
            return false;
        } else {
            $this->em->persist($user);
            if ($andFlush)
                $this->em->flush($user);
            return true;
        }
    }

    public function createRelaunch(Application $application, Relaunch $relaunch, $andFlush = true)
    {
        if (!$application instanceof Application)
            throw new NotFoundHttpException('Relance non reconnue');

        if (!$relaunch instanceof Relaunch)
            throw new NotFoundHttpException('Relance non reconnue');

        $relaunch->setApplication($application);

        $application->addRelaunch($relaunch);

        $this->em->persist($relaunch);

        if ($andFlush)
            $this->em->flush($relaunch);

        return true;

    }

    public function createApplication(Application $application, User $user, $andFlush = true)
    {
        if (!$application instanceof Application)
            throw new NotFoundHttpException('Candidature non reconnue');

        if (!$user instanceof User)
            throw new NotFoundHttpException('Utilisateur non reconnu');

        $application->setUser($user);

        $user->addApplication($application);

        $this->em->persist($application);

        if ($andFlush)
            $this->em->flush($application);

        return true;
    }

    public function createAppointment(Appointment $appointment, User $user, $andFlush = true)
    {
        if (!$appointment instanceof Appointment)
            throw new NotFoundHttpException('Entretien non reconnu');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $appointment->setUser($user);

        $user->addAppointment($appointment);

        $this->em->persist($appointment);

        if ($andFlush)
            $this->em->flush($appointment);

        return true;
    }

    public function createCompany(Company $company, User $user, $andFlush = true)
    {
        if (!$company instanceof Company)
            throw new NotFoundHttpException('Entreprise non reconnue');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $company->setUser($user);

        $user->addCompany($company);

        $this->em->persist($company);

        if ($andFlush)
            $this->em->flush($company);

        return true;
    }

    public function createPreference(Preference $preference, User $user, $andFlush = true)
    {
        if (!$preference instanceof Preference)
            throw new NotFoundHttpException('Préférence non reconnue');

        if (!is_object($user) || !$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur non reconnu');
        }

        $preference->setUser($user);

        $user->addPreference($preference);

        $this->em->persist($preference);

        if ($andFlush)
            $this->em->flush($preference);

        return true;
    }

}

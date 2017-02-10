<?php

namespace JG\CoreBundle\Services\Crud;

use Doctrine\ORM\EntityManagerInterface;
use JG\CoreBundle\Entity\Alert;
use JG\CoreBundle\Entity\EntityInterface\ExportInterface;
use JG\UserBundle\Entity\User;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UpdateDatas
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function moderateAlert(Alert $alert, $viewed, $andFlush = true)
    {
        if (!$alert instanceof Alert)
            throw new NotFoundHttpException('Alerte non reconnue');

        $alert->setViewed($viewed);

        $this->em->persist($alert);

        $this->em->flush($alert);

        return true;
    }

}

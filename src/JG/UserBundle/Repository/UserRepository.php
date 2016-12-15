<?php

namespace JG\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAllUsers()
    {
        return
            $this->_em
            ->createQuery('SELECT u FROM JGUserBundle:User u WHERE NOT u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_ADMIN"%' )
            ->getResult();
    }

    public function findAllAdmin()
    {
        return
            $this->_em
                ->createQuery('SELECT u FROM JGUserBundle:User u WHERE u.roles LIKE :role')
                ->setParameter('role', '%"ROLE_ADMIN"%' )
                ->getResult();
    }
}

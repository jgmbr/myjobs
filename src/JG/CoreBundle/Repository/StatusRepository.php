<?php

namespace JG\CoreBundle\Repository;

/**
 * StatusRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StatusRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCount()
    {
        return $this
            ->createQueryBuilder('s')
            ->select('COUNT(s)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
<?php

namespace MyJobs\CoreBundle\Repository;

/**
 * ContractRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContractRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCount()
    {
        return $this
            ->createQueryBuilder('c')
            ->select('COUNT(c)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}

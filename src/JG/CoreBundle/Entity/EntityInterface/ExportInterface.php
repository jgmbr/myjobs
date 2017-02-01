<?php
/**
 * Created by PhpStorm.
 * User: Justine GAMBIER
 * Date: 01/02/2017
 * Time: 15:41
 */

namespace JG\CoreBundle\Entity\EntityInterface;

interface ExportInterface
{
    /**
     * @return array
     */
    public function toCsvArray();
}
<?php

namespace MyJobs\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MyJobsUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

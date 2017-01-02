<?php

namespace JG\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JGUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

<?php

namespace JG\CoreBundle\Twig\Extension;

class TwigExtension extends \Twig_Extension
{

    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'file_exists'   => new \Twig_Function_Function('file_exists')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twig_extension';
    }
}

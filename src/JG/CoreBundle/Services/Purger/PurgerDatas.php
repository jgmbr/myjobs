<?php

namespace JG\CoreBundle\Services\Purger;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

class PurgerDatas
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function deleteDir($dirPath)
    {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }

        $files = glob($dirPath . '*', GLOB_MARK);

       foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }

        rmdir($dirPath);
    }

    public function deleteFile($dirPath)
    {
        $files = glob($dirPath . '*', GLOB_MARK);

        foreach ($files as $file) {
            unlink($file);
        }
    }

    public function purgeCSV()
    {
        $sourceDir = $this->container->getParameter('jg_core.dir.csv');

        $dirs = array_diff(scandir($sourceDir), array('..', '.'));

        if (sizeof($dirs) > 0) {
            foreach ($dirs as $dir) {
                $this->deleteDir($sourceDir.$dir);
            }
        }
    }

    public function purgeZIP()
    {
        $zipDir = $this->container->getParameter('jg_core.dir.zip');

        $files = array_diff(scandir($zipDir), array('..', '.'));

        if (sizeof($files) > 0) {
            foreach ($files as $file) {
                $this->deleteFile($zipDir . $file);
            }
        }

    }
}

<?php

namespace JG\CoreBundle\Services\Purger;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

class PurgerDatas
{
    private $csvDir;
    private $zipDir;

    public function __construct($csvDir, $zipDir)
    {
        $this->csvDir = $csvDir;
        $this->zipDir = $zipDir;
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
        $dirs = array_diff(scandir($this->csvDir), array('..', '.'));

        if (sizeof($dirs) > 0) {
            foreach ($dirs as $dir) {
                $this->deleteDir($this->csvDir.$dir);
            }
        }
    }

    public function purgeZIP()
    {
        $files = array_diff(scandir($this->zipDir), array('..', '.'));

        if (sizeof($files) > 0) {
            foreach ($files as $file) {
                $this->deleteFile($this->zipDir . $file);
            }
        }

    }
}

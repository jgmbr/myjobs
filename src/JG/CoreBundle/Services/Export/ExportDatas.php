<?php

namespace JG\CoreBundle\Services\Export;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ExportDatas
{
    private $em;
    private $tokenStorage;
    private $csvDir;
    private $zipDir;
    private $delimiter;
    private $extension;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, $csvDir, $zipDir, $delimiter, $extension)
    {
        $this->em               = $em;
        $this->tokenStorage     = $tokenStorage;
        $this->csvDir           = $csvDir;
        $this->zipDir           = $zipDir;
        $this->delimiter        = $delimiter;
        $this->extension        = $extension;
    }

    public function cleanFolder($path)
    {
        $fs = new Filesystem();
        if (!file_exists($path)) {
            $fs->mkdir($path);
        } else {
            $files = array_diff(scandir($path), array('..', '.'));
            foreach ($files as $file) {
                unlink($path.$file);
            }
        }
    }

    public function export($entity, $query, $options = null, $headers, $file, $user = null, $force = true)
    {
        $delimiter = $this->delimiter;

        $extension = $this->extension;

        if ($user) {
            // for user exports
            $iterableResult = $this->em->getRepository($entity)->$query($user, $options);
        } else {
            // for admin exports
            $iterableResult = $this->em->getRepository($entity)->$query();
        }

        $handle = fopen('php://memory', 'r+');

        fputcsv($handle, $headers, $delimiter);

        while (false !== ($row = $iterableResult->next())) {
            fputcsv($handle, $row[0]->toCsvArray(), $delimiter);
            $this->em->detach($row[0]);
        }
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        if ($force) {
            return new Response($content, 200, array(
                'Content-Type' => 'application/force-download',
                'Content-Disposition' => 'attachment; filename="'.$file.$extension.'"'
            ));
        } else {
            try {
                $link = $this->csvDir.$user->getId().'/'.$file.$extension;
                $fs = new Filesystem();
                $fs->touch($link);
                $fs->dumpFile($link, $content);
            } catch (IOExceptionInterface $e) {
                die(var_dump("An error occurred while creating your directory at ".$e->getPath()));
            }
        }

    }
}

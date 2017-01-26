<?php

namespace JG\CoreBundle\Services\Export;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ExportDatas
{
    /**
    * @var EntityManagerInterface
    */
    private $em;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(KernelInterface $kernel, EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;

        $this->kernel = $kernel;

        $this->tokenStorage   = $tokenStorage;
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

    public function export($entity, $query, $headers, $file, $user = null, $force = true)
    {
        $delimiter = ";";

        $extension = ".csv";

        if ($user)
            $iterableResult = $this->em->getRepository($entity)->$query($user);
        else
            $iterableResult = $this->em->getRepository($entity)->$query();

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
                $path = $this->kernel->getRootDir().'/../web/download/csv/';
                $dir = $path.$user->getId().'/';
                $link = $dir.$file.$extension;
                $fs = new Filesystem();
                $fs->touch($link);
                $fs->dumpFile($link, $content);
            } catch (IOExceptionInterface $e) {
                die(var_dump("An error occurred while creating your directory at ".$e->getPath()));
            }
        }

    }
}

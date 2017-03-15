<?php

namespace Helper;

use Event\FileCreatedEvent;
use Events;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TemporaryFilesHelper
{
    /**
     * @var string
     */
    protected $temporaryFolder;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * TemporaryFilesHelper constructor.
     *
     * @param string                   $temporaryFolder
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        $temporaryFolder,
        EventDispatcherInterface $dispatcher
    ) {
        if (is_null($temporaryFolder)) {
            $temporaryFolder = sys_get_temp_dir();
        }
        $temporaryFolder = preg_replace('#/$#', '', $temporaryFolder);

        $this->temporaryFolder = $temporaryFolder;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return string
     */
    public function getTemporaryFolder()
    {
        return $this->temporaryFolder;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public function createTemporaryFile($filename)
    {
        $temporaryFolder = $this->getTemporaryFolder();
        $this->ensureDirExists($temporaryFolder);
        $temporaryFolder = realpath($temporaryFolder);

        $index = 0;
        do {
            $index++;
            $temporaryFile = $temporaryFolder.'/'.$index.'/'.$filename;
            if (file_exists($temporaryFile)) {
                continue;
            }

            $this->ensureDirExists($temporaryFolder.'/'.$index);

            break;
        } while (true);

        $this->dispatcher->dispatch(
            Events::FILE_TEMPORARY_CREATE,
            new FileCreatedEvent($temporaryFile)
        );

        return $temporaryFile;
    }

    /**
     * @param string $directory
     *
     * @return void
     * @throws \Exception
     */
    private function ensureDirExists($directory){
        if (is_dir($directory)){
            return;
        }

        if (mkdir($directory)){
            return;
        }

        throw new \Exception("Unable to create the given directory ($directory given).");
    }
}

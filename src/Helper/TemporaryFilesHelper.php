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
        $temporaryFolder = realpath($temporaryFolder);

        $index = 0;
        do {
            $index++;
            $temporaryFile = $temporaryFolder.'/'.$index.'/'.$filename;
            if (file_exists($temporaryFile)){
                continue;
            }

            if (!is_dir($temporaryFolder.'/'.$index)){
                if (!mkdir($temporaryFolder.'/'.$index)) {
                    continue;
                }
            }

            break;
        } while (true);

        $this->dispatcher->dispatch(
            Events::FILE_TEMPORARY_CREATE,
            new FileCreatedEvent($temporaryFile)
        );

        return $temporaryFile;
    }

}

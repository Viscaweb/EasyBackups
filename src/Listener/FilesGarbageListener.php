<?php

namespace Listener;

use Collector\GarbageFileCollector;
use Event\BackupEndsEvent;
use Event\FileCreatedEvent;

final class FilesGarbageListener
{

    /**
     * @var GarbageFileCollector
     */
    private $fileCollector;

    /**
     * FilesGarbageListener constructor.
     *
     * @param GarbageFileCollector $fileCollector
     */
    public function __construct(GarbageFileCollector $fileCollector)
    {
        $this->fileCollector = $fileCollector;
    }

    /**
     * @param FileCreatedEvent $event
     */
    public function onTemporaryFileCreated(FileCreatedEvent $event)
    {
        $this->fileCollector->addFile($event->getFilename());
    }

    /**
     * @param BackupEndsEvent $event
     */
    public function onBackupsEnds(BackupEndsEvent $event)
    {
        $output = $event->getOutput();
        $output->writeln('');
        $output->writeln('Cleaning the garbage...');

        foreach ($this->fileCollector->getFiles() as $file) {
            $fileLog = "\t→ $file: ";
            $fileLog .= $this->tryDeletingFile($file);
            $output->writeln($fileLog);
        }
    }

    /**
     * @param $file
     *
     * @return bool
     */
    private function deleteFile($file)
    {
        return @unlink($file);
    }

    /**
     * @param $file
     *
     * @return string
     */
    private function tryDeletingFile($file)
    {
        if (!file_exists($file)){
            return 'file not found (deleted or renamed meanwhile?) ✓';
        }

        if (!$this->deleteFile($file)){
            return 'file could not be deleted ✖';
        }

        return 'file deleted ✓';
    }

}

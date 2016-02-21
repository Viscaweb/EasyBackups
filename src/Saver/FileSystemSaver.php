<?php
namespace Saver;

use Models\File;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Saver\Exceptions\CanNotSavedException;

/**
 * Class FileSystemSaver
 */
class FileSystemSaver implements Saver
{
    /**
     * @var string
     */
    protected $backupFolder;

    /**
     * FileSystemSaver constructor.
     *
     * @param string $backupFolder
     */
    public function __construct(
        $backupFolder
    ) {
        $this->backupFolder = $backupFolder;
    }

    /**
     * @param File[] $files
     *
     * @return File[]
     *
     * @throws CanNotSavedException
     */
    public function save($files)
    {
        $fileSystemAdapter = new Local('/');
        $fileSystem = new Filesystem($fileSystemAdapter);
        $savedFiles = [];

        $i = 0;
        foreach ($files as $file) {
            $i++;
            $newBackupLocation = $this->backupFolder.'/dump'.$i.'.tar.xz';
            $currBackupLocation = $file->getPath();

            if ($fileSystem->has($newBackupLocation)) {
                $fileSystem->delete($newBackupLocation);
            }

            if (!$fileSystem->rename($currBackupLocation, $newBackupLocation)) {
                throw new CanNotSavedException();
            }

            $savedFiles[] = new File(
                $fileSystemAdapter->applyPathPrefix($newBackupLocation)
            );
        }

        return $savedFiles;
    }
}

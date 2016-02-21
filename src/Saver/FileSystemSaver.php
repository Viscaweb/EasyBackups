<?php
namespace Saver;

use Models\File;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Resolver\FileNameResolver;
use Saver\Exceptions\CanNotSavedException;

/**
 * Class FileSystemSaver
 */
class FileSystemSaver implements Saver
{
    /** @var FileNameResolver */
    private $fileNameResolver;

    /** @var string */
    protected $backupFolder;

    /**
     * FileSystemSaver constructor.
     *
     * @param FileNameResolver $fileNameResolver
     * @param string           $backupFolder
     */
    public function __construct(
        FileNameResolver $fileNameResolver,
        $backupFolder
    ) {
        $this->fileNameResolver = $fileNameResolver;
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

            $filePath = $this->fileNameResolver->resolve(
                new \DateTime('now', new \DateTime('UTC')),
                'database',
                'tax_xz'
            );

            $newBackupLocation = $this->backupFolder.'/'.$filePath;
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

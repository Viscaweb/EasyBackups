<?php
namespace Saver;

use FileSystem\File;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Saver\Exceptions\CanNotSavedException;

/**
 * Class FileSystemSaver
 */
class FileSystemSaver implements Saver
{
    /**
     * @param File[] $files
     *
     * @return File[]
     *
     * @throws CanNotSavedException
     */
    public function save($files)
    {
        $fileSystemAdapter = new Local(sys_get_temp_dir());
        $fileSystem = new Filesystem($fileSystemAdapter);
        $savedFiles = [];

        $i = 0;
        foreach ($files as $file) {
            $i++;
            $fileContent = file_get_contents($file->getPath());
            $fileLocation = 'dump'.$i.'.tar.xz';
            if (!$fileSystem->write($fileLocation, $fileContent)) {
                throw new CanNotSavedException();
            }

            $savedFiles[] = new File(
                $fileSystemAdapter->applyPathPrefix($fileLocation)
            );
        }

        return $savedFiles;
    }
}

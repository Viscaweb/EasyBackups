<?php
namespace Saver;

use Helper\TemporaryFilesHelper;
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
     * @var TemporaryFilesHelper
     */
    protected $filesHelper;

    /**
     * TarXzCompressor constructor.
     *
     * @param TemporaryFilesHelper $filesHelper
     */
    public function __construct(TemporaryFilesHelper $filesHelper)
    {
        $this->filesHelper = $filesHelper;
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
        $tmpFolder =  $this->filesHelper->getTemporaryFolder();
        $fileSystemAdapter = new Local($tmpFolder);
        $fileSystem = new Filesystem($fileSystemAdapter);
        $savedFiles = [];

        $i = 0;
        foreach ($files as $file) {
            $i++;
            $fileContent = file_get_contents($file->getPath());
            $fileLocation = 'dump'.$i.'.tar.xz';

            if ($fileSystem->has($fileLocation)) {
                $fileSystem->delete($fileLocation);
            }

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

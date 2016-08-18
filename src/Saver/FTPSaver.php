<?php
namespace Saver;

use Adapter\FTPWildCardSearchAdapter;
use Models\File;
use League\Flysystem\Filesystem;
use Resolver\FileNameResolver;
use Saver\Exceptions\CanNotSavedException;

/**
 * Class FTPSaver
 */
class FTPSaver extends AbstractSaver implements Saver
{
    /** @var FileNameResolver */
    private $fileNameResolver;

    /** @var string */
    private $ftpHost;

    /** @var string */
    private $ftpUser;

    /** @var string */
    private $ftpPass;

    /** @var string */
    private $ftpPort;

    /** @var string */
    private $ftpMainPath;

    /**
     * FTPSaver constructor.
     *
     * @param FileNameResolver $fileNameResolver
     * @param string           $ftpHost
     * @param string           $ftpUser
     * @param string           $ftpPass
     * @param string           $ftpPort
     * @param string           $ftpMainPath
     */
    public function __construct(
        FileNameResolver $fileNameResolver,
        $ftpHost,
        $ftpUser,
        $ftpPass,
        $ftpPort,
        $ftpMainPath
    ) {
        $this->fileNameResolver = $fileNameResolver;
        $this->ftpHost = $ftpHost;
        $this->ftpUser = $ftpUser;
        $this->ftpPass = $ftpPass;
        $this->ftpPort = $ftpPort;
        $this->ftpMainPath = $ftpMainPath;
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
        $fileSystemAdapter = $this->getAdapter();
        $fileSystem = new Filesystem($fileSystemAdapter);
        $savedFiles = [];

        $i = 0;
        foreach ($files as $file) {
            $i++;

            $saveLocation = $this->fileNameResolver->resolve(
                new \DateTime('now', new \DateTimeZone('UTC')),
                'database',
                $file->getExtension()
            );

            if ($fileSystem->has($saveLocation)){
                $fileSystem->delete($saveLocation);
            }

            $stream = fopen($file->getPath(), 'r+');
            $uploadFile = $fileSystem->writeStream($saveLocation, $stream);
            fclose($stream);

            if (!$uploadFile) {
                throw new CanNotSavedException();
            }

            $savedFiles[] = new File(
                $fileSystemAdapter->applyPathPrefix($saveLocation)
            );
        }

        return $savedFiles;
    }

    /**
     * @return FTPWildCardSearchAdapter
     */
    protected function getAdapter()
    {
        return new FTPWildCardSearchAdapter(
            [
                'host' => $this->ftpHost,
                'username' => $this->ftpUser,
                'password' => $this->ftpPass,
                'port' => $this->ftpPort,
                'root' => $this->ftpMainPath,
                'allowSearchingUsingWildCard' => true,
            ]
        );
    }

}

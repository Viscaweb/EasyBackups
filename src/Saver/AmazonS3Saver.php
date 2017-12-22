<?php

namespace Saver;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Config;
use Models\File;
use Models\Path;
use Models\Reports\FileReportModel;
use Resolver\FileNameResolver;
use Saver\Exceptions\CanNotSavedException;

/**
 * Class AmazonS3Saver.
 */
class AmazonS3Saver extends AbstractSaver implements Saver
{
    /** @var FileNameResolver */
    private $fileNameResolver;

    /** @var string */
    private $instanceBucket;

    /** @var string */
    private $instanceKey;

    /** @var string */
    private $instanceSecret;

    /** @var string */
    private $instanceRegion;

    /** @var string */
    private $instanceVersion;

    /**
     * AmazonS3Saver constructor.
     *
     * @param FileNameResolver $fileNameResolver
     * @param string           $instanceBucket
     * @param string           $instanceKey
     * @param string           $instanceSecret
     * @param string           $instanceRegion
     * @param string           $instanceVersion
     */
    public function __construct(
        FileNameResolver $fileNameResolver,
        $instanceBucket,
        $instanceKey,
        $instanceSecret,
        $instanceRegion,
        $instanceVersion
    ) {
        $this->fileNameResolver = $fileNameResolver;
        $this->instanceBucket = $instanceBucket;
        $this->instanceKey = $instanceKey;
        $this->instanceSecret = $instanceSecret;
        $this->instanceRegion = $instanceRegion;
        $this->instanceVersion = $instanceVersion;
    }

    /**
     * @param string $fileIdentifier
     * @param File[] $files
     *
     * @return File[]
     * @throws CanNotSavedException
     */
    public function save($fileIdentifier, $files)
    {
        $amazonAdapter = $this->getAdapter();

        $savedFiles = [];
        foreach ($files as $file) {
            $filePath = $this->fileNameResolver->resolve(
                new \DateTime('now', new \DateTimeZone('UTC')),
                $fileIdentifier,
                $file->getExtension()
            );

            $resource = fopen($file->getPath(), 'r');
            $amazonAnswer = $amazonAdapter->writeStream(
                $filePath,
                $resource,
                new Config()
            );
            fclose($resource);

            if ($amazonAnswer === false) {
                throw new CanNotSavedException();
            }

            $savedFiles[] = new File($amazonAnswer['path']);
        }

        return $savedFiles;
    }

    /**
     * @param Path      $path
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     *
     * @return FileReportModel[]
     */
    public function listContents(
        Path $path,
        \DateTime $fromDate,
        \DateTime $toDate
    ) {
        $path->setPath(preg_replace(
            '#^(.+)\/[^\/]+$#',
            '$1',
            $path->getPath()
        ));

        return parent::listContents($path, $fromDate, $toDate);
    }

    /**
     * @return AwsS3Adapter
     */
    protected function getAdapter()
    {
        $client = new S3Client(
            [
                'credentials' => [
                    'key'    => $this->instanceKey,
                    'secret' => $this->instanceSecret,
                ],
                'region'  => $this->instanceRegion,
                'version' => $this->instanceVersion,
            ]
        );

        $amazonAdapter = new AwsS3Adapter($client, $this->instanceBucket);

        return $amazonAdapter;
    }
}

<?php
namespace Saver;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Config;
use Models\File;
use Resolver\FileNameResolver;
use Saver\Exceptions\CanNotSavedException;

/**
 * Class AmazonS3Saver
 */
class AmazonS3Saver implements Saver
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
     * @param File[] $files
     *
     * @return File[]
     *
     * @throws CanNotSavedException
     */
    public function save($files)
    {
        $client = new S3Client(
            [
                'credentials' => [
                    'key' => $this->instanceKey,
                    'secret' => $this->instanceSecret
                ],
                'region' => $this->instanceRegion,
                'version' => $this->instanceVersion,
            ]
        );

        $amazonAdapter = new AwsS3Adapter($client, $this->instanceBucket);

        $savedFiles = [];
        $i = 0;
        foreach ($files as $file) {
            $i++;

            $filePath = $this->fileNameResolver->resolve(
                new \DateTime('now', new \DateTime('UTC')),
                'database',
                'tax_xz'
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

            $amazonFile = $this->instanceBucket.'@'.$amazonAnswer['path'];
            $savedFiles[] = new File($amazonFile);
        }

        return $savedFiles;
    }
}

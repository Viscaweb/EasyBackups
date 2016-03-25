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
class AmazonS3Saver implements Saver, Reader
{
    /** @var FileNameResolver */
    private $fileNameResolver;

    /** @var AwsS3Adapter */
    private $amazonAdapter;

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

        $client = new S3Client(
            [
                'credentials' => [
                    'key' => $instanceKey,
                    'secret' => $instanceSecret
                ],
                'region' => $instanceRegion,
                'version' => $instanceVersion,
            ]
        );
        $this->amazonAdapter = new AwsS3Adapter($client, $instanceBucket);
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
        $savedFiles = [];
        $i = 0;
        foreach ($files as $file) {
            $i++;

            $filePath = $this->fileNameResolver->resolve(
                new \DateTime('now', new \DateTimeZone('UTC')),
                'database',
                'tax_xz'
            );

            $resource = fopen($file->getPath(), 'r');
            $amazonAnswer = $this->amazonAdapter->writeStream(
                $filePath,
                $resource,
                new Config()
            );
            fclose($resource);

            if ($amazonAnswer === false) {
                throw new CanNotSavedException();
            }

            $savedFiles[] = new File(
                $this->getAmazonPathName($amazonAnswer['path'])
            );
        }

        return $savedFiles;
    }

    /**
     * @param string $pattern
     *
     * @return File[]
     */
    public function listFiles($pattern)
    {
        $patternFolder = preg_replace('#^(.+\/)[^\/]+$#', '$1', $pattern);
        $rawFiles = $this->amazonAdapter->listContents($patternFolder, true);

        $files = [];
        $patternRegex = $this->getPatternRegex($pattern);
        foreach ($rawFiles as $rawFile) {
            $path = $rawFile['path'];
            if (!preg_match($patternRegex, $path)) {
                continue;
            }

            $file = new File($this->getAmazonPathName($path));
            $files[] = $file;
        }

        return $files;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getAmazonPathName($path)
    {
        return $this->amazonAdapter->getBucket().'@'.$path;
    }

    /**
     * @param $pattern
     *
     * @return string
     */
    private function getPatternRegex($pattern)
    {
        $patternRegex = str_replace('\\*', '*', preg_quote($pattern, '#'));

        return '#'.$patternRegex.'#';
    }


}

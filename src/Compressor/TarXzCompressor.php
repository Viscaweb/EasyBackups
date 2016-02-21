<?php
namespace Compressor;

use Helper\ShellExecutorHelper;
use Helper\TemporaryFilesHelper;
use Models\File;

/**
 * Class TarXzCompressor
 */
class TarXzCompressor implements Compressor
{
    /**
     * @var TemporaryFilesHelper
     */
    protected $filesHelper;

    /**
     * @var ShellExecutorHelper
     */
    protected $shellExecutor;

    /**
     * TarXzCompressor constructor.
     *
     * @param TemporaryFilesHelper $filesHelper
     * @param ShellExecutorHelper  $shellExecutor
     */
    public function __construct(
        TemporaryFilesHelper $filesHelper,
        ShellExecutorHelper $shellExecutor
    ) {
        $this->filesHelper = $filesHelper;
        $this->shellExecutor = $shellExecutor;
    }

    /**
     * @param File[] $files
     *
     * @return File[]
     */
    public function compress($files)
    {
        $compressedLocation = $this->filesHelper->createTemporaryFile(
            'compressed'
        );
        $compressedCommand = $this->createCommand(
            $files,
            $compressedLocation
        );

        shell_exec($compressedCommand);

        if (file_exists($compressedLocation) && filesize(
                $compressedLocation
            ) > 0
        ) {
            $compressedFile = new File($compressedLocation);

            return [$compressedFile];
        }

        return [];
    }


    /**
     * @param File[] $files
     * @param string $compressTo
     *
     * @return string
     */
    private function createCommand($files, $compressTo)
    {
        $filesToCompress = [];
        foreach ($files as $file) {
            $filesToCompress[] = escapeshellarg($file->getPath());
        }
        $filesToCompressInline = implode(' ', $filesToCompress);

        $command = sprintf(
            self::COMPRESS_STRUCTURE,
            escapeshellarg($compressTo),
            $filesToCompressInline
        );

        return $command;
    }

    const COMPRESS_STRUCTURE = 'tar cfJP %s %s';

}

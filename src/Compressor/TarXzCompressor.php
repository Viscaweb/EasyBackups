<?php
namespace Compressor;

use Helper\DeepestCommonFolderHelper;
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
     * @var DeepestCommonFolderHelper
     */
    protected $deepestCommonFolderHelper;

    /**
     * TarXzCompressor constructor.
     *
     * @param TemporaryFilesHelper      $filesHelper
     * @param ShellExecutorHelper       $shellExecutor
     * @param DeepestCommonFolderHelper $deepestCommonFolderHelper
     */
    public function __construct(
        TemporaryFilesHelper $filesHelper,
        ShellExecutorHelper $shellExecutor,
        DeepestCommonFolderHelper $deepestCommonFolderHelper
    ) {
        $this->filesHelper = $filesHelper;
        $this->shellExecutor = $shellExecutor;
        $this->deepestCommonFolderHelper = $deepestCommonFolderHelper;
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
        $baseFolder = $this->deepestCommonFolderHelper->findDeepest($files);

        $filesToCompress = [];
        foreach ($files as $file) {
            $filePathFromBaseFolder = substr(
                $file->getPath(),
                strlen($baseFolder) + 1
            );
            $filesToCompress[] = escapeshellarg($filePathFromBaseFolder);
        }
        $filesToCompressInline = implode(' ', $filesToCompress);

        $command = sprintf(
            self::COMPRESS_STRUCTURE,
            escapeshellarg($compressTo),
            $baseFolder,
            $filesToCompressInline
        );

        return $command;
    }

    const COMPRESS_STRUCTURE = 'tar cfJP %s -C %s %s';

}

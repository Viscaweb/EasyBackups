<?php
namespace Compressor;

use Helper\DeepestCommonFolderHelper;
use Helper\ShellExecutorHelper;
use Helper\TemporaryFilesHelper;
use Models\File;

/**
 * Class AbstractCompressor
 */
abstract class AbstractCompressor implements Compressor
{
    /**
     * @return string
     */
    abstract protected function getExtension();

    /**
     * @param string $compressTo
     * @param string $baseFolder
     * @param string $filesToCompressInline
     *
     * @return string
     */
    abstract protected function compressCommand(
        $compressTo,
        $baseFolder,
        $filesToCompressInline
    );

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
            'compressed.'.$this->getExtension()
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

        return $this->compressCommand(
            $compressTo,
            $baseFolder,
            $filesToCompressInline
        );
    }

}

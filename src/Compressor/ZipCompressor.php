<?php

namespace Compressor;

/**
 * Class ZipCompressor.
 */
class ZipCompressor extends AbstractCompressor implements Compressor
{
    /**
     * @return string
     */
    protected function getExtension()
    {
        return 'zip';
    }

    /**
     * @param string $compressTo
     * @param string $baseFolder
     * @param string $filesToCompressInline
     *
     * @return string
     */
    protected function compressCommand(
        $compressTo,
        $baseFolder,
        $filesToCompressInline
    ) {
        $moveToFolderCommand = 'cd '.escapeshellarg($baseFolder);
        $compressToZipCommand = sprintf(
            'zip %s %s',
            escapeshellarg($compressTo),
            $filesToCompressInline
        );

        return "$moveToFolderCommand && $compressToZipCommand";
    }
}

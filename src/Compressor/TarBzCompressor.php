<?php

namespace Compressor;

/**
 * Class TarBzCompressor.
 */
class TarBzCompressor extends AbstractCompressor implements Compressor
{
    protected function getExtension()
    {
        return 'tar.bz2';
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
        $compressCommand = sprintf(
            'tar -cvjSf %s -C %s %s',
            escapeshellarg($compressTo),
            $baseFolder,
            $filesToCompressInline
        );

        return $compressCommand;
    }
}

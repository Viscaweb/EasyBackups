<?php

namespace Compressor;

/**
 * Class TarGzCompressor.
 */
class TarGzCompressor extends AbstractCompressor implements Compressor
{
    protected function getExtension()
    {
        return 'tar.gz';
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
            'tar -zcvf %s -C %s %s',
            escapeshellarg($compressTo),
            $baseFolder,
            $filesToCompressInline
        );

        return $compressCommand;
    }
}

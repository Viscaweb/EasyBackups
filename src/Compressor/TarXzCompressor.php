<?php

namespace Compressor;

/**
 * Class TarXzCompressor.
 */
class TarXzCompressor extends AbstractCompressor implements Compressor
{
    protected function getExtension()
    {
        return 'tar.xz';
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
            'tar cfJP %s -C %s %s',
            escapeshellarg($compressTo),
            $baseFolder,
            $filesToCompressInline
        );

        return $compressCommand;
    }
}

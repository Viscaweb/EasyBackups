<?php

namespace Compressor;

use FileSystem\File;

interface Compressor
{
    /**
     * @param File[] $files
     *
     * @return File[]
     */
    public function compress($files);
}

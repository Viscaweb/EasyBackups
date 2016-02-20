<?php

namespace Compressor;

use Models\File;

interface Compressor
{
    /**
     * @param File[] $files
     *
     * @return File[]
     */
    public function compress($files);
}

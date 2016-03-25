<?php

namespace Saver;

use Models\File;

interface Reader
{

    /**
     * @param string $pattern
     *
     * @return File[]
     */
    public function listFiles($pattern);

}

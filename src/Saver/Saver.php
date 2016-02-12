<?php

namespace Saver;

use FileSystem\File;
use Saver\Exceptions\CanNotSavedException;

interface Saver
{

    /**
     * @param File[] $files
     *
     * @return File[]
     *
     * @throws CanNotSavedException
     */
    public function save($files);

}

<?php

namespace Saver;

use Models\Path;
use Models\File;
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

    /**
     * @param Path $path
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     *
     * @return File[]
     */
    public function listContents(
        Path $path,
        \DateTime $fromDate,
        \DateTime $toDate
    );

}

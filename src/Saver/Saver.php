<?php

namespace Saver;

use Models\File;
use Models\Path;
use Saver\Exceptions\CanNotSavedException;

interface Saver
{
    /**
     * @param string $fileIdentifier
     * @param File[] $files
     *
     * @return File[]
     */
    public function save($fileIdentifier, $files);

    /**
     * @param Path      $path
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

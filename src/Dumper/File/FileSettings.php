<?php

namespace Dumper\File;

/**
 * Class FileSettings.
 */
class FileSettings
{
    /**
     * @var string
     */
    private $path;

    /**
     * FileSettings constructor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }
}

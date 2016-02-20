<?php
namespace Models;

/**
 * Class File
 */
class File
{

    /**
     * @var string
     */
    private $path;

    /**
     * File constructor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

}

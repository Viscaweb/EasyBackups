<?php
namespace Models;

/**
 * Class Path
 */
class Path
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

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

    /**
     * @return string
     */
    public function getExtension()
    {
        if (preg_match('/((\.[A-z0-9]{2,3})+)$/', $this->getPath(), $args)){
            return substr($args[0], 1);
        }

        return '';
    }

}

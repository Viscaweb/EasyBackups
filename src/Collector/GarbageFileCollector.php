<?php
namespace Collector;

final class GarbageFileCollector
{
    /**
     * @var string[]
     */
    private $files;

    /**
     * GarbageFileCollector constructor.
     */
    public function __construct()
    {
        $this->files = [];
    }

    /**
     * @param $file
     *
     * @return $this
     */
    public function addFile($file){
        if (!in_array($file, $this->files)){
            $this->files[] = $file;
        }

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getFiles()
    {
        return $this->files;
    }

}

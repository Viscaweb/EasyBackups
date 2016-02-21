<?php

namespace Helper;

class TemporaryFilesHelper
{

    /**
     * @var string
     */
    protected $temporaryFolder;

    /**
     * TemporaryFilesHelper constructor.
     *
     * @param string $temporaryFolder
     */
    public function __construct($temporaryFolder)
    {
        if (is_null($temporaryFolder)){
            $temporaryFolder = sys_get_temp_dir();
        }
        $temporaryFolder = preg_replace('#/$#', '', $temporaryFolder);

        $this->temporaryFolder = $temporaryFolder;
    }

    /**
     * @return string
     */
    public function getTemporaryFolder()
    {
        return $this->temporaryFolder;
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public function createTemporaryFile($prefix){
        return tempnam($this->temporaryFolder, $prefix);
    }

}

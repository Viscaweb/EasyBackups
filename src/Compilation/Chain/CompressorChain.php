<?php
namespace Compilation\Chain;

use Compressor\Compressor;

/**
 * Class CompressorChain
 */
class CompressorChain
{

    /**
     * @var Compressor[]
     */
    private $compressors;

    /**
     * CompressorChain constructor.
     */
    public function __construct()
    {
        $this->compressors = [];
    }

    /**
     * @param string     $alias
     * @param Compressor $compressor
     */
    public function addCompressor($alias, Compressor $compressor)
    {
        $this->compressors[$alias] = $compressor;
    }

    /**
     * @param $alias
     *
     * @return Compressor
     */
    public function getCompressor($alias)
    {
        if (array_key_exists($alias, $this->compressors)) {
            return $this->compressors[$alias];
        }
    }

}

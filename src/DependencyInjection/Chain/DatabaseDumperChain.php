<?php

namespace DependencyInjection\Chain;

use Dumper\Database\DatabaseDumper;

/**
 * Class DatabaseDumperChain.
 */
class DatabaseDumperChain
{
    /**
     * @var DatabaseDumper[]
     */
    private $dumpers;

    /**
     * DatabaseDumperChain constructor.
     */
    public function __construct()
    {
        $this->dumpers = [];
    }

    /**
     * @param string         $alias
     * @param DatabaseDumper $dumper
     */
    public function addDumper($alias, DatabaseDumper $dumper)
    {
        $this->dumpers[$alias] = $dumper;
    }

    /**
     * @param $alias
     *
     * @return DatabaseDumper
     */
    public function getDumper($alias)
    {
        if (array_key_exists($alias, $this->dumpers)) {
            return $this->dumpers[$alias];
        }
    }
}

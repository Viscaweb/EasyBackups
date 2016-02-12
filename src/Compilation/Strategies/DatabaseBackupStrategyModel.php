<?php

namespace Compilation\Strategies;

use \Dumper\Database\DatabaseSettings;

class DatabaseBackupStrategyModel
{
    /**
     * @var string
     */
    private $compressorStrategy;

    /**
     * @var string
     */
    private $fileSaverStrategy;

    /**
     * @var string
     */
    private $databaseType;

    /**
     * @var DatabaseSettings
     */
    private $databaseSettings;

    /**
     * DatabaseBackupStrategyModel constructor.
     *
     * @param string $compressorStrategy
     * @param string $fileSaverStrategy
     * @param string $databaseType
     * @param DatabaseSettings $databaseSettings
     */
    public function __construct(
        $compressorStrategy,
        $fileSaverStrategy,
        $databaseType,
        DatabaseSettings $databaseSettings
    ) {
        $this->compressorStrategy = $compressorStrategy;
        $this->fileSaverStrategy = $fileSaverStrategy;
        $this->databaseType = $databaseType;
        $this->databaseSettings = $databaseSettings;
    }

}

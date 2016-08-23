<?php

namespace Models\Strategies;

use Dumper\Database\DatabaseSettings;

class DatabaseBackupStrategyModel
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $description;

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
     * @param string           $identifier
     * @param string           $compressorStrategy
     * @param string           $fileSaverStrategy
     * @param string           $databaseType
     * @param DatabaseSettings $databaseSettings
     */
    public function __construct(
        $identifier,
        $compressorStrategy,
        $fileSaverStrategy,
        $databaseType,
        DatabaseSettings $databaseSettings
    ) {
        $this->identifier = $identifier;
        $this->compressorStrategy = $compressorStrategy;
        $this->fileSaverStrategy = $fileSaverStrategy;
        $this->databaseType = $databaseType;
        $this->databaseSettings = $databaseSettings;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     *
     * @return DatabaseBackupStrategyModel
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return DatabaseBackupStrategyModel
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompressorStrategy()
    {
        return $this->compressorStrategy;
    }

    /**
     * @param string $compressorStrategy
     *
     * @return DatabaseBackupStrategyModel
     */
    public function setCompressorStrategy($compressorStrategy)
    {
        $this->compressorStrategy = $compressorStrategy;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileSaverStrategy()
    {
        return $this->fileSaverStrategy;
    }

    /**
     * @param string $fileSaverStrategy
     *
     * @return DatabaseBackupStrategyModel
     */
    public function setFileSaverStrategy($fileSaverStrategy)
    {
        $this->fileSaverStrategy = $fileSaverStrategy;

        return $this;
    }

    /**
     * @return string
     */
    public function getDatabaseType()
    {
        return $this->databaseType;
    }

    /**
     * @param string $databaseType
     *
     * @return DatabaseBackupStrategyModel
     */
    public function setDatabaseType($databaseType)
    {
        $this->databaseType = $databaseType;

        return $this;
    }

    /**
     * @return DatabaseSettings
     */
    public function getDatabaseSettings()
    {
        return $this->databaseSettings;
    }

    /**
     * @param DatabaseSettings $databaseSettings
     *
     * @return DatabaseBackupStrategyModel
     */
    public function setDatabaseSettings($databaseSettings)
    {
        $this->databaseSettings = $databaseSettings;

        return $this;
    }
}

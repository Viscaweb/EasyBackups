<?php

namespace Dumper\Database;

/**
 * Class DatabaseSettings.
 */
class DatabaseSettings
{
    /**
     * @var string
     */
    private $dbHost;

    /**
     * @var string
     */
    private $dbUser;

    /**
     * @var string
     */
    private $dbPass;

    /**
     * @var string
     */
    private $dbName;

    /**
     * @var int
     */
    private $dbPort;

    /**
     * @var string[]|null
     */
    private $ignoredTables;

    /**
     * @var bool
     */
    private $optionDropDatabases;

    /**
     * @var bool
     */
    private $optionDropTables;

    /**
     * @var bool
     */
    private $optionAddLocks;

    /**
     * @var bool
     */
    private $forceDump;

    /**
     * @var bool
     */
    private $oneDumpPerTable;

    /**
     * DatabaseSettings constructor.
     *
     * @param string    $dbHost
     * @param string    $dbUser
     * @param string    $dbPass
     * @param string    $dbName
     * @param int       $dbPort
     * @param \string[] $ignoredTables
     * @param bool      $oneDumpPerTable
     */
    public function __construct(
        $dbHost,
        $dbUser,
        $dbPass,
        $dbName,
        $dbPort = self::DEFAULT_DATABASE_PORT,
        array $ignoredTables = null,
        $oneDumpPerTable = false
    ) {
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
        $this->dbPort = (int) $dbPort;
        $this->ignoredTables = $ignoredTables;
        $this->oneDumpPerTable = $oneDumpPerTable;
    }

    /**
     * @param null|\string[] $ignoredTables
     *
     * @return DatabaseSettings
     */
    public function setIgnoredTables($ignoredTables)
    {
        $this->ignoredTables = $ignoredTables;

        return $this;
    }

    /**
     * @param bool $optionDropDatabases
     *
     * @return DatabaseSettings
     */
    public function setOptionDropDatabases($optionDropDatabases)
    {
        $this->optionDropDatabases = $optionDropDatabases;

        return $this;
    }

    /**
     * @param bool $optionDropTables
     *
     * @return DatabaseSettings
     */
    public function setOptionDropTables($optionDropTables)
    {
        $this->optionDropTables = $optionDropTables;

        return $this;
    }

    /**
     * @param bool $optionAddLocks
     *
     * @return DatabaseSettings
     */
    public function setOptionAddLocks($optionAddLocks)
    {
        $this->optionAddLocks = $optionAddLocks;

        return $this;
    }

    /**
     * @param bool $forceDump
     *
     * @return DatabaseSettings
     */
    public function setForceDump($forceDump)
    {
        $this->forceDump = $forceDump;

        return $this;
    }

    /**
     * @param bool $oneDumpPerTable
     *
     * @return DatabaseSettings
     */
    public function setOneDumpPerTable($oneDumpPerTable)
    {
        $this->oneDumpPerTable = $oneDumpPerTable;

        return $this;
    }

    /**
     * @return string
     */
    public function getDbHost()
    {
        return $this->dbHost;
    }

    /**
     * @return string
     */
    public function getDbUser()
    {
        return $this->dbUser;
    }

    /**
     * @return string
     */
    public function getDbPass()
    {
        return $this->dbPass;
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * @return int
     */
    public function getDbPort()
    {
        return $this->dbPort;
    }

    /**
     * @return null|\string[]
     */
    public function getIgnoredTables()
    {
        return $this->ignoredTables;
    }

    /**
     * @return bool
     */
    public function isOptionDropDatabases()
    {
        return $this->optionDropDatabases;
    }

    /**
     * @return bool
     */
    public function isOptionDropTables()
    {
        return $this->optionDropTables;
    }

    /**
     * @return bool
     */
    public function isOptionAddLocks()
    {
        return $this->optionAddLocks;
    }

    /**
     * @return bool
     */
    public function isForceDump()
    {
        return $this->forceDump;
    }

    /**
     * @return bool
     */
    public function wantsOneDumpPerTable()
    {
        return $this->oneDumpPerTable;
    }

    const DEFAULT_DATABASE_PORT = 3306;
}

<?php
namespace Dumper\Database;

/**
 * Class DatabaseSettings
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
     * DatabaseSettings constructor.
     *
     * @param string    $dbHost
     * @param string    $dbUser
     * @param string    $dbPass
     * @param string    $dbName
     * @param int       $dbPort
     * @param \string[] $ignoredTables
     */
    public function __construct(
        $dbHost,
        $dbUser,
        $dbPass,
        $dbName,
        $dbPort = self::DEFAULT_DATABASE_PORT,
        array $ignoredTables = null
    ) {
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
        $this->dbPort = (int) $dbPort;
        $this->ignoredTables = $ignoredTables;
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
     * @param boolean $optionDropDatabases
     *
     * @return DatabaseSettings
     */
    public function setOptionDropDatabases($optionDropDatabases)
    {
        $this->optionDropDatabases = $optionDropDatabases;

        return $this;
    }

    /**
     * @param boolean $optionDropTables
     *
     * @return DatabaseSettings
     */
    public function setOptionDropTables($optionDropTables)
    {
        $this->optionDropTables = $optionDropTables;

        return $this;
    }

    /**
     * @param boolean $optionAddLocks
     *
     * @return DatabaseSettings
     */
    public function setOptionAddLocks($optionAddLocks)
    {
        $this->optionAddLocks = $optionAddLocks;

        return $this;
    }

    /**
     * @param boolean $forceDump
     *
     * @return DatabaseSettings
     */
    public function setForceDump($forceDump)
    {
        $this->forceDump = $forceDump;

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
     * @return boolean
     */
    public function isOptionDropDatabases()
    {
        return $this->optionDropDatabases;
    }

    /**
     * @return boolean
     */
    public function isOptionDropTables()
    {
        return $this->optionDropTables;
    }

    /**
     * @return boolean
     */
    public function isOptionAddLocks()
    {
        return $this->optionAddLocks;
    }

    /**
     * @return boolean
     */
    public function isForceDump()
    {
        return $this->forceDump;
    }

    const DEFAULT_DATABASE_PORT = 3306;

}

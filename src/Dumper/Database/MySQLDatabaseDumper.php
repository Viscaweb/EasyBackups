<?php

namespace Dumper\Database;

use Helper\ShellExecutorHelper;
use Helper\TemporaryFilesHelper;
use Models\File;

/**
 * Class MySQLDatabaseDumper
 */
class MySQLDatabaseDumper implements DatabaseDumper
{
    /**
     * @var TemporaryFilesHelper
     */
    protected $filesHelper;

    /**
     * @var ShellExecutorHelper
     */
    protected $shellExecutor;

    /**
     * MySQLDatabaseDumper constructor.
     *
     * @param TemporaryFilesHelper $filesHelper
     * @param ShellExecutorHelper  $shellExecutor
     */
    public function __construct(
        TemporaryFilesHelper $filesHelper,
        ShellExecutorHelper $shellExecutor
    ) {
        $this->filesHelper = $filesHelper;
        $this->shellExecutor = $shellExecutor;
    }

    /**
     * Returns the list of files generated for this dump.
     *
     * @param DatabaseSettings $settings
     *
     * @return File[]
     */
    public function dump(DatabaseSettings $settings)
    {
        $files = [];

        if ($settings->wantsOneDumpPerTable()) {
            foreach ($this->getAllTables($settings) as $table) {
                $dumpLocation = $this->filesHelper->createTemporaryFile(
                    'database_table_'.$table
                );
                $dumpCommand = $this->createCommand(
                    $settings,
                    $dumpLocation,
                    $table
                );

                $this->shellExecutor->execute($dumpCommand);

                if (file_exists($dumpLocation) && filesize($dumpLocation) > 0) {
                    $files[] = new File($dumpLocation);
                }
            }
        } else {
            $dumpLocation = $this->filesHelper->createTemporaryFile('database');
            $dumpCommand = $this->createCommand($settings, $dumpLocation);

            $this->shellExecutor->execute($dumpCommand);

            if (file_exists($dumpLocation) && filesize($dumpLocation) > 0) {
                $files[] = new File($dumpLocation);
            }
        }

        return $files;
    }

    /**
     * @param DatabaseSettings $settings
     * @param string           $dumpLocation
     * @param null|string      $filterTable
     *
     * @return string
     */
    private function createCommand(
        DatabaseSettings $settings,
        $dumpLocation,
        $filterTable = null
    ) {
        /*
         * Dumping options
         */
        $dumpingOptions = '';
        if ($settings->isOptionAddLocks()) {
            $dumpingOptions .= '--add-locks	';
        }
        if ($settings->isOptionDropDatabases()) {
            $dumpingOptions .= '--add-drop-table ';
        }
        if ($settings->isOptionAddLocks()) {
            $dumpingOptions .= '--add-locks ';
        }
        if ($settings->isForceDump()) {
            $dumpingOptions .= '--force ';
        }
        if ($filterTable === null && count($settings->getIgnoredTables()) > 0) {
            foreach ($settings->getIgnoredTables() as $ignoredTable) {
                $dumpingOptions .= '--ignore-table='
                    .escapeshellarg($settings->getDbName())
                    .'.'.
                    escapeshellarg($ignoredTable).
                    ' ';
            }
        }

        /*
         * Dumping commands
         */
        $command = sprintf(
            self::MYSQLDUMP_STRUCTURE,
            escapeshellarg($settings->getDbHost()),
            escapeshellarg($settings->getDbUser()),
            $settings->getDbPort(),
            escapeshellarg($settings->getDbPass()),
            $dumpingOptions,
            escapeshellarg($settings->getDbName()),
            $filterTable ? escapeshellarg($filterTable) : '',
            $dumpLocation
        );

        return $command;
    }

    /**
     * @param DatabaseSettings $settings
     *
     * @return \string[]
     */
    private function getAllTables(DatabaseSettings $settings)
    {
        $tableListCommand = sprintf(
            self::MYSQL_QUERY_STRUCTURE,
            escapeshellarg($settings->getDbHost()),
            escapeshellarg($settings->getDbUser()),
            $settings->getDbPort(),
            escapeshellarg($settings->getDbPass()),
            escapeshellarg($settings->getDbName()),
            escapeshellarg('SHOW TABLES')
        );

        $rawTablesList = $this->shellExecutor->execute($tableListCommand);

        $tablesList = explode("\n", $rawTablesList);
        unset($tablesList[0]);

        return array_values($tablesList);

    }

    const MYSQLDUMP_STRUCTURE = 'mysqldump -h %s -u %s -P %d --password=%s %s %s %s > %s';

    const MYSQL_QUERY_STRUCTURE = 'mysql -h %s -u %s -P %d --password=%s %s -e %s';
}

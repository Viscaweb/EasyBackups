<?php

namespace Dumper\Database;

use Models\File;

/**
 * Class MySQLDatabaseDumper
 */
class MySQLDatabaseDumper implements DatabaseDumper
{

    /**
     * Returns the list of files generated for this dump.
     *
     * @param DatabaseSettings $settings
     *
     * @return File[]
     */
    public function dump(DatabaseSettings $settings)
    {
        $dumpLocation = sys_get_temp_dir().'/database.sql';
        $dumpCommand = $this->createCommand(
            $settings,
            $dumpLocation
        );

        shell_exec($dumpCommand);

        if (file_exists($dumpLocation) && filesize($dumpLocation) > 0){
            $dumpFile = new File($dumpLocation);
            return [$dumpFile];
        }

        return [];
    }

    /**
     * @param DatabaseSettings $settings
     * @param string           $dumpLocation
     *
     * @return string
     */
    private function createCommand(DatabaseSettings $settings, $dumpLocation)
    {
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
        if (count($settings->getIgnoredTables()) > 0) {
            foreach ($settings->getIgnoredTables() as $ignoredTable) {
                $dumpingOptions .= '--ignore-table='
                    .escapeshellarg($settings->getDbName())
                    .'.'.
                    escapeshellarg($ignoredTable);
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
            $dumpLocation
        );

        return $command;
    }

    const MYSQLDUMP_STRUCTURE = 'mysqldump -h %s -u %s -P %d --password=%s %s %s > %s';
}

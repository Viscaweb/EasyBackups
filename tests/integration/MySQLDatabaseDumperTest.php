<?php

use Dumper\Database\DatabaseDumper;
use Dumper\Database\DatabaseSettings;
use Models\File;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MySQLDatabaseDumperTest extends PHPUnit_Extensions_Database_TestCase
{
    /** @var DatabaseDumper */
    static public $databaseDumper;

    const DB_HOST = '127.0.0.1';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_PRIMARY = 'visca_easybackups_tests';
    const DB_SECONDARY = 'visca_easybackups_tests2';
    const DB_TESTED_TABLE = 'log_history';

    const CMD_IMPORT_DB = 'mysql %s < %s';

    protected function setUp()
    {
        parent::setUp();

        require __DIR__.'/../../app/bootstrap.php';
        $container = getContainer();
        self::$databaseDumper = $container->get('dumper.database.mysql');
    }

    /** @test */
    public function testDumpDbThenImportAreEquals()
    {
        /* Dump the primary database containing the fixtures. */
        $primaryDbSettings = new DatabaseSettings(
            self::DB_HOST,
            self::DB_USER,
            self::DB_PASS,
            self::DB_PRIMARY
        );
        $dumpPrimaryDb = self::$databaseDumper->dump($primaryDbSettings);

        /* Import the dump in order to test it. */
        $this->importDumpInSecondaryDb($dumpPrimaryDb);

        /* Compare DBs */
        $dbSecondary = $this->getPdo(self::DB_SECONDARY);
        $e = $dbSecondary->createDataSet([self::DB_TESTED_TABLE]);

        $this->assertDataSetsEqual($e, $this->getDataSet());
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        return $this->getPdo(self::DB_PRIMARY);
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__.'/fixtures/log_history.yml'
        );
    }

    /**
     * @param $dbName
     *
     * @return PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     */
    private function getPdo($dbName)
    {
        $db = new PDO(
            "mysql:host=".self::DB_HOST.";dbname=$dbName",
            self::DB_USER,
            self::DB_PASS
        );

        return $this->createDefaultDBConnection($db);
    }

    /**
     * @param File[] $files
     */
    private function importDumpInSecondaryDb($files)
    {
        $inlineFiles = '';
        foreach ($files as $file) {
            $inlineFiles .= ' '.escapeshellarg($file->getPath());
        }

        $command = sprintf(
            self::CMD_IMPORT_DB,
            escapeshellarg(self::DB_SECONDARY),
            $inlineFiles
        );
        shell_exec($command);
    }
}


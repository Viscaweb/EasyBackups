<?php
use League\Flysystem\Adapter\Local;

require 'vendor/autoload.php';

/*
 * Dump the database
 */
$dbSettings = new \Dumper\Database\DatabaseSettings(
    'localhost',
    'root',
    '',
    'test_wp',
    '3306'
);

$mysqlDumper = new \Dumper\Database\MySQLDatabaseDumper();

$filesToDump = $mysqlDumper->dump($dbSettings);

/*
 * Save the files
 */
$fileSystemAdapter = new Local(sys_get_temp_dir());
$fileSystem = new \League\Flysystem\Filesystem($fileSystemAdapter);

$i = 0;
foreach($filesToDump as $file){
    $i++;
    var_dump($fileSystem->write('dump'.$i.'.sql', file_get_contents($file)));
}

<?php
require 'vendor/autoload.php';

$dbSettings = new \Dumper\Database\DatabaseSettings(
    'localhost',
    'root',
    '',
    'test_wp',
    '3306'
);

$mysqlDumper = new \Dumper\Database\MySQLDatabaseDumper();
print_r($mysqlDumper->dump($dbSettings));
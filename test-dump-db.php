<?php
use Dumper\Database\DatabaseDumper;
use League\Flysystem\Adapter\Local;
use FileSystem\File;
require 'vendor/autoload.php';

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'test_wp';
$dbPort = 3306;
$exportTo = sys_get_temp_dir();

/*
 * Load services
 */
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
$loader->load(__DIR__.'/app/services.yml');

/** @var DatabaseDumper $dumper */
$dumper = $container->get('dumper.database.mysql');

/*
 * Dump the database
 */
$dbSettings = new \Dumper\Database\DatabaseSettings(
    $dbHost,
    $dbUser,
    $dbPass,
    $dbName,
    $dbPort
);

$filesToDump = $dumper->dump($dbSettings);

/*
 * Compress the files
 */
$compressor = new \Compressor\TarXzCompressor();
$compressedFiles = $compressor->compress($filesToDump);

/*
 * Save the files
 */
$fileSystemAdapter = new Local($exportTo);
$fileSystem = new \League\Flysystem\Filesystem($fileSystemAdapter);

$i = 0;
foreach($compressedFiles as $file){
    $i++;
    $fileContent = file_get_contents($file->getPath());
    $fileLocation = 'dump'.$i.'.tar.xz';
    var_dump($fileSystem->write($fileLocation, $fileContent));
}

shell_exec('open '.escapeshellarg($exportTo));
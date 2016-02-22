<?php

namespace Processor;

use DependencyInjection\Chain\CompressorChain;
use DependencyInjection\Chain\DatabaseDumperChain;
use DependencyInjection\Chain\SaverChain;
use Models\File;
use Models\Strategies\DatabaseBackupStrategyModel;
use Processor\Exceptions\UnableToProcessException;

class DatabaseDumperStrategyProcessor
{
    /**
     * @var DatabaseDumperChain
     */
    private $chainDatabasesDumper;

    /**
     * @var CompressorChain
     */
    private $chainCompressor;

    /**
     * DatabaseDumperStrategyProcessor constructor.
     *
     * @param DatabaseDumperChain $chainDatabasesDumper
     * @param CompressorChain     $chainCompressor
     * @param SaverChain          $chainSaver
     */
    public function __construct(
        DatabaseDumperChain $chainDatabasesDumper,
        CompressorChain $chainCompressor,
        SaverChain $chainSaver
    ) {
        $this->chainDatabasesDumper = $chainDatabasesDumper;
        $this->chainCompressor = $chainCompressor;
        $this->chainSaver = $chainSaver;
    }

    /**
     * @var SaverChain
     */
    private $chainSaver;

    /**
     * @param DatabaseBackupStrategyModel $configuration
     * @param callable                    $setActionName
     *
     * @return File[]
     *
     * @throws UnableToProcessException
     */
    public function dump(
        DatabaseBackupStrategyModel $configuration,
        callable $setActionName
    ) {
        /* Dump the database */
        $setActionName('Dumping database...');
        $databaseDumper = $this->chainDatabasesDumper->getDumper(
            $configuration->getDatabaseType()
        );
        $dumpFiles = $databaseDumper->dump(
            $configuration->getDatabaseSettings()
        );

        /* Compress the database */
        $setActionName('Compressing database...');
        $compressor = $this->chainCompressor->getCompressor(
            $configuration->getCompressorStrategy()
        );
        $dumpCompressedFiles = $compressor->compress($dumpFiles);

        /* Save the files */
        $setActionName('Saving files...');
        $saver = $this->chainSaver->getSaver(
            $configuration->getFileSaverStrategy()
        );
        $savedFiles = $saver->save($dumpCompressedFiles);

        return $savedFiles;
    }

}

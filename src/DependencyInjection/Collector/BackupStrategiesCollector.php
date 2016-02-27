<?php

namespace DependencyInjection\Collector;

use Dumper\Database\DatabaseSettings;
use InvalidArgumentException;
use Models\Strategies\DatabaseBackupStrategyModel;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class BackupStrategiesCollector
{

    /**
     * @return DatabaseBackupStrategyModel[]
     */
    public function collectDatabasesStrategies()
    {
        $fileLocator = new FileLocator(__DIR__.'/../../../app/config');
        try {
            $fileStrategies = $fileLocator->locate('strategies.yml');
        } catch (InvalidArgumentException $ex){
            /* No strategies file detected? No strategies then. :=) */
            return [];
        }

        $strategies = file_get_contents($fileStrategies);

        $config = Yaml::parse($strategies);
        $config = $config['easy_backups'];

        $processor = new Processor();
        $configuration = new DatabaseStrategyConfiguration();

        $validatedConfig = $processor->processConfiguration($configuration, [$config]);

        $strategies = [];
        if (isset($validatedConfig['strategies'])){
            foreach($validatedConfig['strategies'] as $strategyConfig){
                $strategy = new DatabaseBackupStrategyModel(
                    $strategyConfig['identifier'],
                    $strategyConfig['compressor_strategy'],
                    $strategyConfig['saver_strategy'],
                    $strategyConfig['dump_settings']['type'],
                    new DatabaseSettings(
                        $strategyConfig['dump_settings']['options']['host'],
                        $strategyConfig['dump_settings']['options']['user'],
                        $strategyConfig['dump_settings']['options']['pass'],
                        $strategyConfig['dump_settings']['options']['name'],
                        $strategyConfig['dump_settings']['options']['port'],
                        $strategyConfig['dump_settings']['options']['ignore_tables']
                    )
                );
                $strategy->setDescription($strategyConfig['description']);
                $strategies[] = $strategy;
            }
        }

        return $strategies;
    }

}
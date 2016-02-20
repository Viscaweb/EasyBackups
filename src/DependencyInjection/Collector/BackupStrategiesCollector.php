<?php

namespace DependencyInjection\Collector;

use Dumper\Database\DatabaseSettings;
use Models\Strategies\DatabaseBackupStrategyModel;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

class BackupStrategiesCollector
{

    /**
     * @return DatabaseBackupStrategyModel[]
     */
    public function collectDatabasesStrategies()
    {
        $config = Yaml::parse(
            file_get_contents(__DIR__.'/../../Resources/config/strategies.yml')
        );
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
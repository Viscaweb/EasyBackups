<?php
require __DIR__.'/../vendor/autoload.php';

use DependencyInjection\Collector\DatabaseStrategyConfiguration;
use DependencyInjection\CompilerPass\CompressorCompilerPass;
use DependencyInjection\CompilerPass\DatabaseDumperCompilerPass;
use DependencyInjection\CompilerPass\SaverCompilerPass;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

/*
 * Load services
 */
$container = new ContainerBuilder();
$container->addCompilerPass(new CompressorCompilerPass());
$container->addCompilerPass(new DatabaseDumperCompilerPass());
$container->addCompilerPass(new SaverCompilerPass());

$fileLocator = new FileLocator(__DIR__.'/../app/config');
$loader = new YamlFileLoader($container, $fileLocator);
$loader->load('parameters.yml');
$loader->load('services.yml');

$container->compile();

/*
 * Load the configuration
 */
$loader = new YamlFileLoader($container, $fileLocator);
$configFile = $fileLocator->locate('strategies.yml');
$config = Yaml::parse(file_get_contents($configFile));

$processor = new Processor();
$configuration = new DatabaseStrategyConfiguration();
$processedConfiguration = $processor->processConfiguration($configuration, $config);
<?php
namespace Command;

use DependencyInjection\Collector\BackupStrategiesCollector;
use Processor\DatabaseDumperStrategyProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DatabaseDumperCommand extends Command
{
    /**
     * @var BackupStrategiesCollector
     */
    private $collectorDbStrategy;

    /**
     * @var DatabaseDumperStrategyProcessor
     */
    private $processorDatabaseDumper;

    /**
     * DatabaseDumperCommand constructor.
     *
     * @param BackupStrategiesCollector $collectorDbStrategy
     * @param DatabaseDumperStrategyProcessor $processorDatabaseDumper
     */
    public function __construct(
        BackupStrategiesCollector $collectorDbStrategy,
        DatabaseDumperStrategyProcessor $processorDatabaseDumper
    ) {
        parent::__construct();

        $this->collectorDbStrategy = $collectorDbStrategy;
        $this->processorDatabaseDumper = $processorDatabaseDumper;
    }


    protected function configure()
    {
        $this
            ->setName('dumper:databases')
            ->setDescription(
                'Dump all databases strategies registered in the app.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Exporting databases');

        $io->section('Exporting all databases');

        $strategies = $this->collectorDbStrategy->collectDatabasesStrategies();
        $totalStrategies = count($strategies);
        $io->writeln($totalStrategies.' strategie(s) found.');

        $progressBar = new ProgressBar($output, $totalStrategies);
        $progressBar->setFormat(self::PROGRESS_BAR_FORMAT);
        $progressBar->setMessage('Beginning backuping');

        $progressBar->start();
        $reportContent = new \ArrayObject;
        foreach($strategies as $strategy){
            $strategyIdentifier = $strategy->getIdentifier();
            $setProgressBarMessage = function ($message) use ($progressBar, $strategyIdentifier){
                $message = "[$strategyIdentifier] $message";
                $progressBar->setMessage($message);
                $progressBar->display();
            };

            $exportedFiles = $this->processorDatabaseDumper->dump($strategy, $setProgressBarMessage);

            $reportContent->append("Backuping of the database: $strategyIdentifier");
            foreach($exportedFiles as $file){
                $filename = $file->getPath();
                $reportContent->append("\t→ $filename");
            }

            $progressBar->advance();
        }
        $progressBar->finish();
        $io->newLine(2);

        $io->section('Report');
        $io->text($reportContent->getArrayCopy());
    }
    const PROGRESS_BAR_FORMAT = ' %current%/%max% [%bar%] %percent:3s%% %memory:6s% %message%';

}

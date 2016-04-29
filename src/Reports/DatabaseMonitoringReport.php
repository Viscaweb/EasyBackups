<?php
namespace Reports;

use DependencyInjection\Chain\SaverChain;
use Models\Path;
use Models\Reports\FileReportModel;
use Models\Strategies\DatabaseBackupStrategyModel;
use Resolver\FileNameResolver;

class DatabaseMonitoringReport
{
    /** @var SaverChain */
    private $chainSaver;

    /** @var FileNameResolver */
    private $fileNameResolver;

    /**
     * DatabaseMonitoringReport constructor.
     *
     * @param SaverChain       $chainSaver
     * @param FileNameResolver $fileNameResolver
     */
    public function __construct(
        SaverChain $chainSaver,
        FileNameResolver $fileNameResolver
    ) {
        $this->chainSaver = $chainSaver;
        $this->fileNameResolver = $fileNameResolver;
    }

    /**
     * @param DatabaseBackupStrategyModel $databaseStrategyModel
     * @param \DateTime                   $fromDate
     * @param \DateTime                   $untilDate
     *
     * @return FileReportModel[]
     */
    public function getReport(
        DatabaseBackupStrategyModel $databaseStrategyModel,
        \DateTime $fromDate,
        \DateTime $untilDate
    ) {
        $fileReader = $this->chainSaver->getSaver(
            $databaseStrategyModel->getFileSaverStrategy()
        );

        $filesFound = [];
        $date = clone $fromDate;
        while ($date->getTimestamp() <= $untilDate->getTimestamp()) {
            $filesPattern = $this->fileNameResolver->resolvePatternForDay(
                $date,
                'database',
                'tax_xz'
            );
            $filesPatternPath = new Path($filesPattern);

            $filesFound = array_merge(
                $filesFound,
                $fileReader->listContents(
                    $filesPatternPath,
                    (clone $date->setTime(0, 0, 0)),
                    (clone $date->setTime(23, 59, 59))
                )
            );

            $date->add(new \DateInterval("PT86400S"));
        }

        return $filesFound;
    }

}

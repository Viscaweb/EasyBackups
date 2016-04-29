<?php
namespace Controller;

use DependencyInjection\Collector\BackupStrategiesCollector;
use Reports\DatabaseMonitoringReport;
use Serializer\FileReportSerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MonitoringController
{
    /** @var BackupStrategiesCollector */
    private $backupStrategiesCollector;

    /** @var FileReportSerializer */
    private $fileReportSerializer;

    /** @var DatabaseMonitoringReport */
    private $dbMonitoringReport;

    /**
     * MonitoringController constructor.
     *
     * @param BackupStrategiesCollector $backupStrategiesCollector
     * @param FileReportSerializer      $fileReportSerializer
     * @param DatabaseMonitoringReport  $dbMonitoringReport
     */
    public function __construct(
        BackupStrategiesCollector $backupStrategiesCollector,
        FileReportSerializer $fileReportSerializer,
        DatabaseMonitoringReport $dbMonitoringReport
    ) {
        $this->backupStrategiesCollector = $backupStrategiesCollector;
        $this->fileReportSerializer = $fileReportSerializer;
        $this->dbMonitoringReport = $dbMonitoringReport;
    }

    /**
     * @param Request $request
     * @param string  $strategyIdentifier
     * @param string  $requestedFromDate
     * @param string  $requestedUntilDate
     *
     * @return JsonResponse
     */
    public function testAction(
        Request $request,
        $strategyIdentifier,
        $requestedFromDate,
        $requestedUntilDate
    ) {
        $fromDate = $this->createDateObject($requestedFromDate);
        $untilDate = $this->createDateObject($requestedUntilDate);
        $strategy = $this->backupStrategiesCollector->getStrategy(
            $strategyIdentifier
        );

        $backupsFound = $this->dbMonitoringReport->getReport(
            $strategy,
            $fromDate,
            $untilDate
        );

        return new JsonResponse(
            $this->fileReportSerializer->serializeMany($backupsFound)
        );
    }

    /**
     * @param $requestedFromDate
     *
     * @return \DateTime
     */
    private function createDateObject($requestedFromDate)
    {
        return
            \DateTime::createFromFormat(
                'Y-m-d',
                $requestedFromDate,
                new \DateTimeZone('UTC')
            )->setTime(0, 0, 0);
    }

}

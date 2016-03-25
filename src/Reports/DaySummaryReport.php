<?php
namespace Reports;

use DateTime;
use Models\Reports\DaySummaryReportModel;
use Models\Reports\FileReportModel;
use Resolver\FileNameResolver;
use Saver\Reader;

class DaySummaryReport
{
    /** @var Reader */
    private $fileReader;

    /** @var FileNameResolver */
    private $fileNameResolver;

    /**
     * DaySummaryReport constructor.
     *
     * @param Reader           $fileReader
     * @param FileNameResolver $fileNameResolver
     */
    public function __construct(
        Reader $fileReader,
        FileNameResolver $fileNameResolver
    ) {
        $this->fileReader = $fileReader;
        $this->fileNameResolver = $fileNameResolver;
    }

    /**
     * @param DateTime $date
     *
     * @return DaySummaryReportModel
     */
    public function generateReport(DateTime $date)
    {
        $report = new DaySummaryReportModel($date);

        $backupFiles = $this->findBackups($date);
        $report->setFiles($backupFiles);

        return $report;
    }

    /**
     * @param DateTime $date
     *
     * @return FileReportModel[]
     */
    private function findBackups(DateTime $date)
    {
        $pattern = $this->fileNameResolver->resolvePatternForDay(
            $date,
            '*',
            '*'
        );

        $filesReport = [];
        $files = $this->fileReader->listFiles($pattern);
        foreach ($files as $file) {
            $filesReport[] = new FileReportModel($file->getPath());
        }

        return $filesReport;
    }

}

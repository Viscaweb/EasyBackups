<?php

namespace Models\Reports;

use DateTime;

class DaySummaryReportModel
{
    /** @var DateTime */
    private $date;

    /** @var FileReportModel[] */
    private $files;

    /**
     * DaySummaryReportModel constructor.
     *
     * @param DateTime $date
     */
    public function __construct(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     *
     * @return DaySummaryReportModel
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return FileReportModel[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param FileReportModel[] $files
     *
     * @return DaySummaryReportModel
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

}

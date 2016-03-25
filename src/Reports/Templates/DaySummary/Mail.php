<?php
namespace Reports\Templates\DaySummary;

use Models\Reports\DaySummaryReportModel;
use Reports\Templates\Template;

final class Mail implements Template
{
    /**
     * @param DaySummaryReportModel $reportData
     *
     * @return string
     */
    public function generateTemplate($reportData)
    {
        throw new \Exception('Not yet implemented');
    }

}
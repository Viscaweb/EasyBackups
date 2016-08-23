<?php

namespace Serializer;

use Models\Reports\FileReportModel;

class FileReportSerializer
{
    /**
     * @param FileReportModel $report
     *
     * @return array
     */
    public function serialize(FileReportModel $report)
    {
        if (is_null($report->getCreationDate())) {
            $inlineDate = null;
        } else {
            $inlineDate = $report->getCreationDate()->format('r');
        }

        return [
            'date' => $inlineDate,
            'size' => $report->getSize(),
            'file' => $report->getFilename(),
        ];
    }

    /**
     * @param FileReportModel[] $reports
     *
     * @return array
     */
    public function serializeMany($reports)
    {
        $serializedReport = [];
        foreach ($reports as $report) {
            $serializedReport[] = $this->serialize($report);
        }

        return $serializedReport;
    }
}

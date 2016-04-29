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
        return [
            'date' => $report->getCreationDate()->format('r'),
            'size' => $report->getSize(),
            'file' => $report->getFilename(),
        ];
    }

    /**
     * @param FileReportModel[] $reports
     *
     * @return array
     */
    public function serializeMany($reports){
        $serializedReport = [];
        foreach($reports as $report){
            $serializedReport[] = $this->serialize($report);
        }

        return $serializedReport;
    }
}

<?php
namespace Saver;

use League\Flysystem\ReadInterface;
use Models\File;
use Models\Path;
use Models\Reports\FileReportModel;
use Saver\Exceptions\CanNotSavedException;

abstract class AbstractSaver implements Saver
{
    /**
     * @param File[] $files
     *
     * @return File[]
     *
     * @throws CanNotSavedException
     */
    abstract public function save($files);

    /**
     * @return ReadInterface
     */
    abstract protected function getAdapter();

    /**
     * @param Path      $path
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     *
     * @return FileReportModel[]
     */
    public function listContents(
        Path $path,
        \DateTime $fromDate,
        \DateTime $toDate
    ) {
        $adapter = $this->getAdapter();

        $files = [];
        $rawFiles = $adapter->listContents(
            $path->getPath(),
            true
        );
        foreach ($rawFiles as $rawFile) {
            if ($rawFile['type'] !== 'file') {
                continue;
            }
            if (isset($rawFile['timestamp'])){
                $creationDate = \DateTime::createFromFormat(
                    'U',
                    $rawFile['timestamp']
                );
            } else {
                $creationDate = null;
            }
            $files[] = new FileReportModel(
                $rawFile['path'],
                $rawFile['size'],
                $creationDate
            );
        }

        $this->sortFilesByDate($files);

        return $files;
    }

    /**
     * @param FileReportModel[] $files
     */
    private function sortFilesByDate(&$files)
    {
        usort($files, [$this, 'fileDateComparison']);
    }

    /**
     * @param FileReportModel $file1
     * @param FileReportModel $file2
     *
     * @return bool
     */
    private function fileDateComparison(
        FileReportModel $file1,
        FileReportModel $file2
    ) {
        if ($file1->getCreationDate() === $file2->getCreationDate()) {
            return 0;
        }

        $time1 = $file1->getCreationDate()->getTimestamp();
        $time2 = $file2->getCreationDate()->getTimestamp();

        return $time1 < $time2 ? -1 : 1;
    }
}

<?php

namespace Models\Reports;

class FileReportModel
{
    /** @var string */
    private $filename;

    /** @var int */
    private $size;

    /** @var \DateTime|null */
    private $creationDate;

    /**
     * FileReportModel constructor.
     *
     * @param string         $filename
     * @param int            $size
     * @param \DateTime|null $creationDate
     */
    public function __construct($filename, $size = -1, \DateTime $creationDate = null)
    {
        $this->filename = $filename;
        $this->size = $size;
        $this->creationDate = $creationDate;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     *
     * @return FileReportModel
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return FileReportModel
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     *
     * @return FileReportModel
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }
}

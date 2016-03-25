<?php

use Models\File;
use Reports\DaySummaryReport;
use Saver\Reader;

class DaySummaryReportTest extends PHPUnit_Framework_TestCase
{
    /** @var DaySummaryReport */
    private $daySummaryReport;

    public function setUp()
    {
        parent::setUp();

        /* Get file name resolver */
        require __DIR__.'/../../app/bootstrap.php';
        $container = getContainer();
        $fileNameResolver = $container->get('resolver.filename');

        /* Get reader */
        $files = [
            new File('file1'),
            new File('file2'),
        ];

        $reader = $this->getMockBuilder(Reader::class)->getMock();
        $reader->method('listFiles')->will($this->returnValue($files));

        $this->daySummaryReport = new DaySummaryReport($reader, $fileNameResolver);
    }

    /** @test */
    public function testReportResult()
    {
        $today = new \DateTime();
        $report = $this->daySummaryReport->generateReport($today);

        $this->assertEquals($today, $report->getDate());
        $this->assertCount(2, $report->getFiles());
    }
}


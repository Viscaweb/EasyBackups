<?php

use Collector\GarbageFileCollector;

class GarbageFileCollectorTest extends PHPUnit_Framework_TestCase
{
    /** @var GarbageFileCollector */
    private $collector;

    public function setUp()
    {
        parent::setUp();

        $this->collector = new GarbageFileCollector();
    }

    /** @test */
    public function testIfCollectorSaveFiles()
    {
        $this->collector
            ->addFile($file1 = 'file1')
            ->addFile($file2 = 'file2')
            ->addFile($file3 = 'file3');

        $collectedFiles = $this->collector->getFiles();

        $this->assertCount(3, $collectedFiles);
        $this->assertEquals($file1, $collectedFiles[0]);
        $this->assertEquals($file2, $collectedFiles[1]);
        $this->assertEquals($file3, $collectedFiles[2]);
    }

}


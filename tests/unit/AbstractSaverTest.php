<?php

use League\Flysystem\ReadInterface;
use Models\Path;
use Models\Reports\FileReportModel;
use Saver\AbstractSaver;

class AbstractSaverTest extends PHPUnit_Framework_TestCase
{
    /** @var FileReportModel */
    private $fakeFile1;

    /** @var FileReportModel */
    private $fakeFile2;

    public function setUp()
    {
        $this->fakeFile1 = new FileReportModel(
            'backup1.tar.gz',
            1024,
            new DateTime('2015-07-03')
        );
        $this->fakeFile2 = new FileReportModel(
            'backup2.tar.gz',
            4096,
            new DateTime('2016-06-25')
        );
    }

    public function testSaverTransformContentsProperly()
    {
        $fakeFiles = [
            $this->convertRealObjectToRawResponse($this->fakeFile1),
            $this->convertRealObjectToRawResponse($this->fakeFile2),
        ];

        $adapterMock = $this->getMockBuilder(ReadInterface::class)->getMock();
        $adapterMock->expects($this->any())->method('listContents')->willReturn(
            $fakeFiles
        );

        $saverMock = $this->getMockForAbstractClass(AbstractSaver::class);
        $saverMock->expects($this->any())->method('getAdapter')->willReturn(
            $adapterMock
        );

        $objectsFound = $saverMock->listContents(
            new Path(''),
            new \DateTime(),
            new \DateTime()
        );

        $this->assertEquals(
            $objectsFound,
            [$this->fakeFile1, $this->fakeFile2]
        );
    }

    public function testSaverOrderContentsProperlyByDate()
    {
        $fakeFilesInWrongOrder = [
            $this->convertRealObjectToRawResponse($this->fakeFile2),
            $this->convertRealObjectToRawResponse($this->fakeFile1),
        ];

        $adapterMock = $this->getMockBuilder(ReadInterface::class)->getMock();
        $adapterMock->expects($this->any())->method('listContents')->willReturn(
            $fakeFilesInWrongOrder
        );

        $saverMock = $this->getMockForAbstractClass(AbstractSaver::class);
        $saverMock->expects($this->any())->method('getAdapter')->willReturn($adapterMock);

        $objectsFound = $saverMock->listContents(
            new Path(''),
            new \DateTime(),
            new \DateTime()
        );

        $this->assertEquals(
            $objectsFound,
            [$this->fakeFile1, $this->fakeFile2]
        );
    }

    /**
     * @return array
     */
    private function convertRealObjectToRawResponse(FileReportModel $file)
    {
        return [
            'type'      => 'file',
            'timestamp' => $file->getCreationDate()->getTimestamp(),
            'path'      => $file->getFilename(),
            'size'      => $file->getSize(),
        ];
    }
}

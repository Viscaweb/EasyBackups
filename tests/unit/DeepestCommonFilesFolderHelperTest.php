<?php

use Helper\DeepestCommonFolderHelper;
use Models\File;

class DeepestCommonFolderHelperTest extends PHPUnit_Framework_TestCase
{
    /** @var DeepestCommonFolderHelper */
    private $helper;

    public function setUp()
    {
        $this->helper = new DeepestCommonFolderHelper();
    }

    /** @test */
    public function testRegularStructureFindsDeepestFolder()
    {
        $deepestFolder = $this->helper->findDeepest([
            new File('/folder-1/folder-2/folder-3/file1.txt'),
            new File('/folder-1/folder-2/folder-3/file2.txt'),
            new File('/folder-1/folder-2/folder-3/file3.txt'),
        ]);

        $this->assertEquals('/folder-1/folder-2/folder-3', $deepestFolder);
    }

    /** @test */
    public function testWeirdStructureFindsDeepestFolder()
    {
        $deepestFolder = $this->helper->findDeepest([
            new File('/folder-1/folder-2/folder-3/file1.txt'),
            new File('/folder-1/folder-2/folder-4/file2.txt'),
            new File('/folder-1/folder-2/file3.txt'),
        ]);

        $this->assertEquals('/folder-1/folder-2', $deepestFolder);
    }

    /** @test */
    public function testFolderEndsWithoutDash()
    {
        $deepestFolder = $this->helper->findDeepest([
            new File('/folder-1/folder-2/file1.txt'),
        ]);

        $this->assertNotEquals('/', substr($deepestFolder, -1));
    }
}

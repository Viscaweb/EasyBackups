<?php

use Models\File;

class FileExtensionTest extends PHPUnit_Framework_TestCase
{

    /** @test */
    public function test()
    {
        $this->assertEquals('tar.xz', (new File('file.tar.xz'))->getExtension());
        $this->assertEquals('tar.gz', (new File('file.tar.gz'))->getExtension());
        $this->assertEquals('tar.bz2', (new File('file.tar.bz2'))->getExtension());
        $this->assertEquals('zip', (new File('file.zip'))->getExtension());
        $this->assertEquals('rar', (new File('file.rar'))->getExtension());
    }
}


<?php

namespace Event;

use Symfony\Component\EventDispatcher\Event;

final class FileCreatedEvent extends Event
{

    /**
     * @var string File created
     */
    private $filename;

    /**
     * FileCreatedEvent constructor.
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

}
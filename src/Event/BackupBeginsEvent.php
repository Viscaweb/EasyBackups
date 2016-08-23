<?php

namespace Event;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;

final class BackupBeginsEvent extends Event
{
    use OutputTrait;

    /**
     * BackupBeginsEvent constructor.
     *
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->setOutput($output);
    }
}

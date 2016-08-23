<?php

namespace Event;

use Symfony\Component\Console\Output\OutputInterface;

trait OutputTrait
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param OutputInterface $output
     *
     * @return OutputTrait
     */
    public function setOutput($output)
    {
        $this->output = $output;

        return $this;
    }
}

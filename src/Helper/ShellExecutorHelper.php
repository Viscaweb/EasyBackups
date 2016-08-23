<?php

namespace Helper;

class ShellExecutorHelper
{
    /**
     * @param $command
     *
     * @return string
     */
    public function execute($command)
    {
        return shell_exec($command);
    }
}

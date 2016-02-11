<?php

namespace Dumper\File;

interface FileDumper
{

    /**
     * Returns the list of files generated for this dump.
     *
     * @param FileSettings $settings
     *
     * @return string[]
     */
    public function dump(FileSettings $settings);

}

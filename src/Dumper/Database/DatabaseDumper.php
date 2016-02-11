<?php

namespace Dumper\Database;

use FileSystem\File;

interface DatabaseDumper
{

    /**
     * Returns the list of files generated for this dump.
     *
     * @param DatabaseSettings $settings
     *
     * @return File[]
     */
    public function dump(DatabaseSettings $settings);

}

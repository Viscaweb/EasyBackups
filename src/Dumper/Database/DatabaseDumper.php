<?php

namespace Dumper\Database;

interface DatabaseDumper
{

    /**
     * Returns the list of files generated for this dump.
     *
     * @param DatabaseSettings $settings
     *
     * @return string[]
     */
    public function dump(DatabaseSettings $settings);

}

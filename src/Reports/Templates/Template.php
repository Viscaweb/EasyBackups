<?php

namespace Reports\Templates;

interface Template
{

    /**
     * @param object $reportData
     *
     * @return string
     */
    public function generateTemplate($reportData);

}

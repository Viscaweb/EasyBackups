<?php

namespace Resolver;

final class FileNameResolver
{
    /** @var string */
    private $fileNameFormat;

    /**
     * NameResolver constructor.
     *
     * @param string $fileNameFormat
     */
    public function __construct($fileNameFormat)
    {
        $this->fileNameFormat = $fileNameFormat;
    }

    /**
     * @param \DateTime $date
     * @param           $fileIdentifier
     * @param           $fileExt
     *
     * @return string
     */
    public function resolve(\DateTime $date, $fileIdentifier, $fileExt)
    {
        $variables = [
            'date-year'   => $date->format('Y'),
            'date-month'  => $date->format('M'),
            'date-day'    => $date->format('d'),
            'date-hour'   => $date->format('H'),
            'date-minute' => $date->format('i'),
            'identifier'  => $fileIdentifier,
            'ext'         => $fileExt,
        ];

        $varValues = array_values($variables);
        $varNames = $this->getVariablesNames($variables);

        return str_replace($varNames, $varValues, $this->fileNameFormat);
    }

    /**
     * @param \DateTime $date
     * @param           $fileIdentifier
     * @param           $fileExt
     *
     * @return string
     */
    public function resolvePatternForDay(
        \DateTime $date,
        $fileIdentifier,
        $fileExt
    ) {
        $variables = [
            'date-year'   => $date->format('Y'),
            'date-month'  => $date->format('M'),
            'date-day'    => $date->format('d'),
            'date-hour'   => '*',
            'date-minute' => '*',
            'identifier'  => $fileIdentifier,
            'ext'         => $fileExt,
        ];

        $varValues = array_values($variables);
        $varNames = $this->getVariablesNames($variables);

        return str_replace($varNames, $varValues, $this->fileNameFormat);
    }

    /**
     * @param $variables
     *
     * @return array
     */
    private function getVariablesNames($variables)
    {
        $protectedVarNames = array_keys($variables);
        $protectedVarNames = array_map(
            function ($val) {
                return '['.$val.']';
            },
            $protectedVarNames
        );

        return $protectedVarNames;
    }
}

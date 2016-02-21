<?php
namespace Resolver;

class FileNameResolver
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
        $variables = $this->getVariables($date, $fileIdentifier, $fileExt);

        $varValues = array_values($variables);
        $protectedVarNames = array_keys($variables);
        $protectedVarNames = array_map(
            function ($val) {
                return '['.$val.']';
            },
            $protectedVarNames
        );

        return str_replace(
            $protectedVarNames,
            $varValues,
            $this->fileNameFormat
        );
    }

    /**
     * @param \DateTime $date
     * @param           $fileIdentifier
     * @param           $fileExt
     *
     * @return array
     */
    private function getVariables(\DateTime $date, $fileIdentifier, $fileExt)
    {
        return [
            'date-year' => $date->format('Y'),
            'date-month' => $date->format('M'),
            'date-day' => $date->format('d'),
            'identifier' => $fileIdentifier,
            'ext' => $fileExt,
        ];
    }

}

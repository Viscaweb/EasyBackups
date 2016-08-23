<?php

namespace Adapter;

use League\Flysystem\Adapter\Ftp;

class FTPWildCardSearchAdapter extends Ftp
{
    /** @var bool */
    private $allowSearchingUsingWildCard;

    /**
     * FTPWildCardSearchAdapter constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->configurable[] = 'allowSearchingUsingWildCard';
        $config['allowSearchingUsingWildCard'] = isset($config['allowSearchingUsingWildCard']) && $config['allowSearchingUsingWildCard'] ?: false;

        parent::__construct($config);
    }

    /**
     * @return bool
     */
    public function isAllowSearchingUsingWildCard()
    {
        return $this->allowSearchingUsingWildCard;
    }

    /**
     * @param bool $allowSearchingUsingWildCard
     *
     * @return FTPWildCardSearchAdapter
     */
    public function setAllowSearchingUsingWildCard($allowSearchingUsingWildCard)
    {
        $this->allowSearchingUsingWildCard = $allowSearchingUsingWildCard;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $directory
     */
    protected function listDirectoryContents($directory, $recursive = true)
    {
        if (!$this->isAllowSearchingUsingWildCard()) {
            $directory = str_replace('*', '\\*', $directory);
        }
        $options = $recursive ? '-alnR' : '-aln';
        $listing = ftp_rawlist($this->getConnection(), $options.' '.$directory);

        return $listing ? $this->normalizeListing($listing, $directory) : [];
    }

    /**
     * Normalize a directory listing.
     *
     * @param array  $listing
     * @param string $prefix
     *
     * @return array directory listing
     */
    protected function normalizeListing(array $listing, $prefix = '')
    {
        $base = ($this->isAllowSearchingUsingWildCard() && strstr($prefix, '*')) ? '.' : $prefix;
        $result = [];
        $listing = $this->removeDotDirectories($listing);

        while ($item = array_shift($listing)) {
            if (preg_match('#^.*:$#', $item)) {
                $base = trim($item, ':');
                continue;
            }

            $result[] = $this->normalizeObject($item, $base);
        }

        return $this->sortListing($result);
    }
}

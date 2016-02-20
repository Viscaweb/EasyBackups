<?php
namespace DependencyInjection\Chain;

use Saver\Saver;

/**
 * Class SaverChain
 */
class SaverChain
{

    /**
     * @var Saver[]
     */
    private $saver;

    /**
     * SaverChain constructor.
     */
    public function __construct()
    {
        $this->saver = [];
    }

    /**
     * @param string $alias
     * @param Saver  $saver
     */
    public function addSaver($alias, Saver $saver)
    {
        $this->saver[$alias] = $saver;
    }

    /**
     * @param $alias
     *
     * @return Saver
     */
    public function getSaver($alias)
    {
        if (array_key_exists($alias, $this->saver)) {
            return $this->saver[$alias];
        }
    }

}

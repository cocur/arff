<?php


namespace Cocur\Arff\Column;

/**
 * NumericColumn
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
class NumericColumn extends AbstractColumn
{
    /**
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        if ($name !== null) {
            $this->setName($name);
        }
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'numeric';
    }
}

<?php


namespace Cocur\Arff\Column;

/**
 * StringColumn
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
class StringColumn extends AbstractColumn
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
        return 'string';
    }
}

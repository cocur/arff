<?php

namespace Cocur\Arff\Column;

/**
 * AbstractColumn
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
abstract class AbstractColumn implements ColumnInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     *
     * @return AbstractColumn
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function render()
    {
        return sprintf('@ATTRIBUTE %s %s', $this->getName(), $this->getType());
    }
}

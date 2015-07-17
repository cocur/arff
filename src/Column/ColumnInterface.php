<?php

namespace Cocur\Arff\Column;

/**
 * Interface ColumnInterface
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
interface ColumnInterface
{
    /**
     * @param string $name
     *
     * @return ColumnInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function render();
}

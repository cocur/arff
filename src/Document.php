<?php

namespace Cocur\Arff;

use Cocur\Arff\Column\ColumnInterface;

/**
 * ArffDocument.
 *
 * @author    Florian Eckerstorfer
 * @copyright 2015-2017 Florian Eckerstorfer
 */
class Document
{
    /**
     * @var string[]
     */
    protected static $allowedTypes = ['numeric', 'nominal', 'string', 'date'];

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ColumnInterface[]
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param string $name Name of the relation
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param ColumnInterface $column
     *
     * @return Document
     */
    public function addColumn(ColumnInterface $column)
    {
        $this->columns[$column->getName()] = $column;

        return $this;
    }

    /**
     * @return ColumnInterface[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param array $row
     *
     * @return Document
     */
    public function addData(array $row)
    {
        foreach ($this->columns as $name => $column) {
            if (!isset($row[$name])) {
                $row[$name] = '?';
            }
        }
        $this->data[] = $row;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}

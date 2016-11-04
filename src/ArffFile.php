<?php

namespace Cocur\Arff;

use Cocur\Arff\Column\ColumnInterface;

/**
 * ArffWriter.
 *
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
class ArffFile
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
     * @return ArffFile
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
     * @return ArffFile
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

    /**
     * @param array $row
     *
     * @return string
     */
    public function renderRow($row)
    {
        $processedRow = [];
        foreach ($this->columns as $name => $column) {
            $value = $row[$name];
            if (preg_match('/\s|,|;/', $value)) {
                $value = sprintf("'%s'", $value);
            }
            $processedRow[] = $value;
        }

        return sprintf("%s\n", implode(',', $processedRow));
    }

    /**
     * @return string
     */
    public function render()
    {
        $content = sprintf("@RELATION %s\n\n", $this->name);
        foreach ($this->columns as $name => $column) {
            $content .= $column->render()."\n";
        }
        $content .= "\n@DATA\n";
        foreach ($this->data as $row) {
            $content .= $this->renderRow($row);
        }

        return $content;
    }

    /**
     * @param string $filename
     *
     * @return ArffFile
     */
    public function write($filename)
    {
        file_put_contents($filename, $this->render());

        return $this;
    }
}

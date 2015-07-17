<?php

namespace Cocur\Arff\Bridge\Plum;

use Cocur\Arff\ArffFile;
use Cocur\Arff\Column\ColumnInterface;
use Plum\Plum\Writer\WriterInterface;

/**
 * ArffWriter
 *
 * @package   Cocur\Arff\Bridge\Plum
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
class ArffWriter implements WriterInterface
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var ArffFile
     */
    protected $arffFile;

    /**
     * @param string            $filename
     * @param string            $name
     * @param ColumnInterface[] $columns
     *
     * @codeCoverageIgnore
     */
    public function __construct($filename, $name, array $columns)
    {
        $this->filename = $filename;
        $this->arffFile = new ArffFile($name);
        foreach ($columns as $column) {
            $this->arffFile->addColumn($column);
        }
    }

    /**
     * Write the given item.
     *
     * @param mixed $item
     *
     * @return void
     */
    public function writeItem($item)
    {
        file_put_contents($this->filename, $this->arffFile->renderRow($item), FILE_APPEND);
    }

    /**
     * Prepare the writer.
     *
     * @return void
     */
    public function prepare()
    {
        $this->arffFile->write($this->filename);
    }

    /**
     * Finish the writer.
     *
     * @return void
     */
    public function finish()
    {
    }
}

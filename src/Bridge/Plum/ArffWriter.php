<?php

namespace Cocur\Arff\Bridge\Plum;

use Cocur\Arff\ArffDocument;
use Cocur\Arff\Column\ColumnInterface;
use Plum\Plum\Writer\WriterInterface;
use Cocur\Arff\ArffWriter as Writer;

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
     * @var ArffDocument
     */
    protected $document;

    /**
     * @var ArffWriter
     */
    protected $writer;

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
        $this->document = new ArffDocument($name);
        foreach ($columns as $column) {
            $this->document->addColumn($column);
        }
        $this->writer = new Writer();
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
        file_put_contents($this->filename, $this->writer->renderRow($this->document, $item), FILE_APPEND);
    }

    /**
     * Prepare the writer.
     *
     * @return void
     */
    public function prepare()
    {
        $writer = new Writer();
        $writer->write($this->document, $this->filename);
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

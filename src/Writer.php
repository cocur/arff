<?php

namespace Cocur\Arff;

/**
 * ArffWriter.
 *
 * @author    Florian Eckerstorfer
 * @copyright 2015-2017 Florian Eckerstorfer
 */
class Writer
{
    /**
     * @param Document $document
     * @param array    $row
     *
     * @return string
     */
    public function renderRow(Document $document, $row)
    {
        $processedRow = [];
        foreach ($document->getColumns() as $name => $column) {
            $value = $row[$name];
            if (preg_match('/\s|,|;/', $value)) {
                $value = sprintf("'%s'", $value);
            }
            $processedRow[] = $value;
        }

        return sprintf("%s\n", implode(',', $processedRow));
    }

    /**
     * @param Document $document
     *
     * @return string
     */
    public function render(Document $document)
    {
        $content = sprintf("@RELATION %s\n\n", $document->getName());
        foreach ($document->getColumns() as $name => $column) {
            $content .= $column->render()."\n";
        }
        $content .= "\n@DATA\n";
        foreach ($document->getData() as $row) {
            $content .= $this->renderRow($document, $row);
        }

        return $content;
    }

    /**
     * @param Document $document
     * @param string   $filename
     *
     * @return Writer
     */
    public function write(Document $document, $filename)
    {
        file_put_contents($filename, $this->render($document));

        return $this;
    }
}

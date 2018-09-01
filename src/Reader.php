<?php

namespace Cocur\Arff;

use Cocur\Arff\Column\DateColumn;
use Cocur\Arff\Column\NominalColumn;
use Cocur\Arff\Column\NumericColumn;
use Cocur\Arff\Column\StringColumn;

class Reader
{
    /**
     * @param string $filename
     *
     * @return Document
     */
    public function readFile($filename)
    {
        $lines    = explode("\n", file_get_contents($filename));
        $document = new Document($this->parseName($lines[0]));

        $this->parseColumns($document, $lines);
        $this->parseData($document, $lines);

        return $document;
    }

    /**
     * @param string $line
     *
     * @return string|null
     */
    protected function parseName($line)
    {
        if (preg_match('/^@RELATION ([a-zA-Z-_\.\/\d]+)$/i', $line, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * @param Document $document
     * @param string[] $lines
     */
    protected function parseColumns(Document $document, array $lines)
    {
        foreach ($lines as $line) {
            if (preg_match('/ATTRIBUTE\s([a-zA-Z0-9_-]+)\s(.*)/i', $line, $matches)) {
                $type   = $matches[2];
                $column = null;
                if (strcasecmp($type, 'string') === 0) {
                    $column = new StringColumn($matches[1]);
                } else if (strcasecmp($type, 'numeric') === 0) {
                    $column = new NumericColumn($matches[1]);
                } else if (preg_match('/^\{(.*)\}$/', $matches[2], $classMatches)) {
                    $column = new NominalColumn($matches[1], array_map(function ($value) {
                        return trim($value, "'");
                    }, preg_split(
                            "/,(?=(?:[^\']*\'[^\']*\')*(?![^\']*\'))/",
                            $classMatches[1]
                        )
                    ));
                } else if (preg_match('/date\s\"/', $matches[2])) {
                    preg_match('/date\s"([A-Za-z0-9-: ]+)"/', $line, $dateMatches);
                    $column = new DateColumn($matches[1], $dateMatches[1]);
                }
                if ($column) {
                    $document->addColumn($column);
                }
            }
        }
    }

    /**
     * @param Document $document
     * @param string[] $lines
     */
    protected function parseData(Document $document, array $lines)
    {
        $index = 0;
        while (!preg_match('/@DATA/i', $lines[$index])) {
            $index++;
        }
        $columns     = $document->getColumns();
        $columnNames = array_keys($columns);
        for ($i = $index+1; $i < count($lines); $i += 1) {
            $row    = [];
            $splits = preg_split(
                "/,(?=(?:[^\']*\'[^\']*\')*(?![^\']*\'))/",
                $lines[$i],
                -1,
                PREG_SPLIT_DELIM_CAPTURE
            );
            foreach ($splits as $j => $value) {
                if (isset($columnNames[$j])) {
                    $row[$columns[$columnNames[$j]]->getName()] = trim($value, "'");
                }
            }

            if (count($row) != count($columnNames)) {
                continue; // malformed, probably and empty line
            }

            $document->addData($row);
        }
    }
}

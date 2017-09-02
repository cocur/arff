<?php

use Cocur\Arff\Document;

function mockArffDocumentWithTwoColumns($name, $columnName1, $columnName2)
{
    /** @var \Cocur\Arff\Column\ColumnInterface|\Mockery\MockInterface $column1 */
    $column1 = \Mockery::mock('Cocur\Arff\Column\ColumnInterface', ['getName' => $columnName1]);
    /** @var \Cocur\Arff\Column\ColumnInterface|\Mockery\MockInterface $column2 */
    $column2 = \Mockery::mock('Cocur\Arff\Column\ColumnInterface', ['getName' => $columnName2]);

    $document = new Document($name);
    $document->addColumn($column1);
    $document->addColumn($column2);

    return $document;
}

function mockArffDocument()
{
    $document = new Document('foobar');
    /** @var \Cocur\Arff\Column\ColumnInterface|\Mockery\MockInterface $column1 */
    $column1 = \Mockery::mock('Cocur\Arff\Column\ColumnInterface', [
        'getName' => 'a',
        'render'  => '@ATTRIBUTE a string',
    ]);
    $document->addColumn($column1);
    /** @var \Cocur\Arff\Column\ColumnInterface|\Mockery\MockInterface $column2 */
    $column2 = \Mockery::mock('Cocur\Arff\Column\ColumnInterface', [
        'getName' => 'b',
        'render'  => '@ATTRIBUTE b numeric',
    ]);
    $document->addColumn($column2);
    /** @var \Cocur\Arff\Column\ColumnInterface|\Mockery\MockInterface $column3 */
    $column3 = \Mockery::mock('Cocur\Arff\Column\ColumnInterface', [
        'getName' => 'c',
        'render'  => '@ATTRIBUTE c {x,y,z}',
    ]);
    $document->addColumn($column3);
    /** @var \Cocur\Arff\Column\ColumnInterface|\Mockery\MockInterface $column4 */
    $column4 = \Mockery::mock('Cocur\Arff\Column\ColumnInterface', [
        'getName' => 'd',
        'render'  => '@ATTRIBUTE d date "yyyy-MM-dd HH:mm:ss"',
    ]);
    $document->addColumn($column4);
    $document->addData(['a' => 'hello', 'b' => 1.5, 'c' => 'x', 'd' => '2015-07-17 16:12:30']);
    $document->addData(['a' => 'hello world', 'b' => 1.5, 'c' => 'x y']);
    $document->addData(['a' => 'hello', 'c' => 'z']);
    $document->addData(['a' => 'hello,world']);
    $document->addData(['a' => 'hello;world']);

    return $document;
}

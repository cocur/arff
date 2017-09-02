<?php

namespace Cocur\Arff;

use PHPUnit\Framework\TestCase;

require_once 'ArffMock.php';

/**
 * ArffFileTest.
 *
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class ArffDocumentTest extends TestCase
{
    /**
     * @test
     * @covers \Cocur\Arff\ArffDocument::__construct()
     * @covers \Cocur\Arff\ArffDocument::getName()
     */
    public function constructorSetsNameAndGetNameReturnsName()
    {
        $file = new ArffDocument('foo');

        $this->assertEquals('foo', $file->getName());
    }

    /**
     * @test
     * @covers \Cocur\Arff\ArffDocument::addColumn()
     * @covers \Cocur\Arff\ArffDocument::getColumns()
     */
    public function addColumnAddsColumnAndGetColumnsReturnsColumns()
    {
        $document = mockArffDocumentWithTwoColumns('foobar', 'foo', 'bar');

        $this->assertCount(2, $document->getColumns());
        $this->assertInstanceOf('Cocur\Arff\Column\ColumnInterface', $document->getColumns()['foo']);
        $this->assertInstanceOf('Cocur\Arff\Column\ColumnInterface', $document->getColumns()['bar']);
    }

    /**
     * @test
     * @covers \Cocur\Arff\ArffDocument::addData()
     * @covers \Cocur\Arff\ArffDocument::getData()
     */
    public function addDataAddsDataAndGetDataReturnsData()
    {
        $document = mockArffDocumentWithTwoColumns('foobar', 'foo', 'bar');
        $document->addData(['foo' => 1, 'bar' => 2]);

        $this->assertEquals(['foo' => 1, 'bar' => 2], $document->getData()[0]);
    }

    /**
     * @test
     * @covers \Cocur\Arff\ArffDocument::addData()
     * @covers \Cocur\Arff\ArffDocument::getData()
     */
    public function addDataAddsDataAndAddsMissingFields()
    {
        $document = mockArffDocumentWithTwoColumns('foobar', 'foo', 'bar');
        $document->addData(['foo' => 1]);

        $this->assertEquals(['foo' => 1, 'bar' => '?'], $document->getData()[0]);
    }
}

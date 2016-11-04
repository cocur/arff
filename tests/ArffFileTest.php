<?php

namespace Cocur\Arff;

use Mockery;
use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_TestCase;

/**
 * ArffFileTest.
 *
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class ArffFileTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers Cocur\Arff\ArffFile::__construct()
     * @covers Cocur\Arff\ArffFile::getName()
     */
    public function constructorSetsNameAndGetNameReturnsName()
    {
        $file = new ArffFile('foo');

        $this->assertEquals('foo', $file->getName());
    }

    /**
     * @test
     * @covers Cocur\Arff\ArffFile::addColumn()
     * @covers Cocur\Arff\ArffFile::getColumns()
     */
    public function addColumnAddsColumnAndGetColumnsReturnsColumns()
    {
        $file = $this->mockArffFileWithTwoColumns('foobar', 'foo', 'bar');

        $this->assertCount(2, $file->getColumns());
        $this->assertInstanceOf('Cocur\Arff\Column\ColumnInterface', $file->getColumns()['foo']);
        $this->assertInstanceOf('Cocur\Arff\Column\ColumnInterface', $file->getColumns()['bar']);
    }

    /**
     * @test
     * @covers Cocur\Arff\ArffFile::addData()
     * @covers Cocur\Arff\ArffFile::getData()
     */
    public function addDataAddsDataAndGetDataReturnsData()
    {
        $file = $this->mockArffFileWithTwoColumns('foobar', 'foo', 'bar');
        $file->addData(['foo' => 1, 'bar' => 2]);

        $this->assertEquals(['foo' => 1, 'bar' => 2], $file->getData()[0]);
    }

    /**
     * @test
     * @covers Cocur\Arff\ArffFile::addData()
     * @covers Cocur\Arff\ArffFile::getData()
     */
    public function addDataAddsDataAndAddsMissingFields()
    {
        $file = $this->mockArffFileWithTwoColumns('foobar', 'foo', 'bar');
        $file->addData(['foo' => 1]);

        $this->assertEquals(['foo' => 1, 'bar' => '?'], $file->getData()[0]);
    }

    /**
     * @test
     * @covers Cocur\Arff\ArffFile::renderRow()
     * @covers Cocur\Arff\ArffFile::render()
     */
    public function renderRendersArffFileAndWritesThemDoDisk()
    {
        $file = $this->mockArffFile();
        $expected = <<<EOF
@RELATION foobar

@ATTRIBUTE a string
@ATTRIBUTE b numeric
@ATTRIBUTE c {x,y,z}
@ATTRIBUTE d date "yyyy-MM-dd HH:mm:ss"

@DATA
hello,1.5,x,'2015-07-17 16:12:30'
'hello world',1.5,'x y',?
hello,?,z,?
'hello,world',?,?,?
'hello;world',?,?,?

EOF;

        $this->assertEquals($expected, $file->render());
    }

    /**
     * @test
     * @covers Cocur\Arff\ArffFile::write()
     */
    public function writeWritesArffFileToDisk()
    {
        $root = vfsStream::setup('fixtures');

        $file = $this->mockArffFile();
        $file->write($root->url().'/data.arff');

        $this->assertTrue($root->hasChild('data.arff'));
    }

    /**
     * @param string $name
     * @param string $columnName1
     * @param string $columnName2
     *
     * @return ArffFile
     */
    protected function mockArffFileWithTwoColumns($name, $columnName1, $columnName2)
    {
        $column1 = Mockery::mock('Cocur\Arff\Column\ColumnInterface', ['getName' => $columnName1]);
        $column2 = Mockery::mock('Cocur\Arff\Column\ColumnInterface', ['getName' => $columnName2]);

        $file = new ArffFile($name);
        $file->addColumn($column1);
        $file->addColumn($column2);

        return $file;
    }

    protected function mockArffFile()
    {
        $file = new ArffFile('foobar');
        $file->addColumn(Mockery::mock('Cocur\Arff\Column\ColumnInterface', [
            'getName' => 'a',
            'render' => '@ATTRIBUTE a string',
        ]));
        $file->addColumn(Mockery::mock('Cocur\Arff\Column\ColumnInterface', [
            'getName' => 'b',
            'render' => '@ATTRIBUTE b numeric',
        ]));
        $file->addColumn(Mockery::mock('Cocur\Arff\Column\ColumnInterface', [
            'getName' => 'c',
            'render' => '@ATTRIBUTE c {x,y,z}',
        ]));
        $file->addColumn(Mockery::mock('Cocur\Arff\Column\ColumnInterface', [
            'getName' => 'd',
            'render' => '@ATTRIBUTE d date "yyyy-MM-dd HH:mm:ss"',
        ]));
        $file->addData(['a' => 'hello', 'b' => 1.5, 'c' => 'x', 'd' => '2015-07-17 16:12:30']);
        $file->addData(['a' => 'hello world', 'b' => 1.5, 'c' => 'x y']);
        $file->addData(['a' => 'hello', 'c' => 'z']);
        $file->addData(['a' => 'hello,world']);
        $file->addData(['a' => 'hello;world']);

        return $file;
    }
}

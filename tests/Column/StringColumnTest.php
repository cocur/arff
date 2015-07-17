<?php


namespace Cocur\Arff\Column;

use PHPUnit_Framework_TestCase;

/**
 * StringColumnTest
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class StringColumnTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers Cocur\Arff\Column\StringColumn::getType()
     */
    public function getTypeReturnsString()
    {
        $this->assertEquals('string', (new StringColumn())->getType());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\AbstractColumn::setName()
     * @covers Cocur\Arff\Column\AbstractColumn::getName()
     */
    public function setNameSetsNameAndGetNameReturnsName()
    {
        $column = new StringColumn();
        $column->setName('foo');

        $this->assertEquals('foo', $column->getName());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\StringColumn::__construct()
     */
    public function constructorSetsName()
    {
        $this->assertEquals('foo', (new StringColumn('foo'))->getName());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\AbstractColumn::render()
     */
    public function renderRendersAttribute()
    {
        $column = new StringColumn('foo');

        $this->assertEquals('@ATTRIBUTE foo string', $column->render());
    }
}

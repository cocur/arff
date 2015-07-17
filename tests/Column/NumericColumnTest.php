<?php

namespace Cocur\Arff\Column;

use PHPUnit_Framework_TestCase;

/**
 * NumericColumnTest
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class NumericColumnTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers Cocur\Arff\Column\NumericColumn::getType()
     */
    public function getTypeReturnsNumeric()
    {
        $this->assertEquals('numeric', (new NumericColumn())->getType());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\AbstractColumn::setName()
     * @covers Cocur\Arff\Column\AbstractColumn::getName()
     */
    public function setNameSetsNameAndGetNameReturnsName()
    {
        $column = new NumericColumn();
        $column->setName('foo');

        $this->assertEquals('foo', $column->getName());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\NumericColumn::__construct()
     */
    public function constructorSetsName()
    {
        $this->assertEquals('foo', (new NumericColumn('foo'))->getName());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\AbstractColumn::render()
     */
    public function renderRendersAttribute()
    {
        $column = new NumericColumn('foo');

        $this->assertEquals('@ATTRIBUTE foo numeric', $column->render());
    }
}

<?php

namespace Cocur\Arff\Column;

use PHPUnit_Framework_TestCase;

/**
 * DateColumnTest
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class DateColumnTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers Cocur\Arff\Column\DateColumn::getType()
     */
    public function getTypeReturnsDate()
    {
        $this->assertEquals('date', (new DateColumn())->getType());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\AbstractColumn::setName()
     * @covers Cocur\Arff\Column\AbstractColumn::getName()
     */
    public function setNameSetsNameAndGetNameReturnsName()
    {
        $column = new DateColumn();
        $column->setName('foo');

        $this->assertEquals('foo', $column->getName());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\DateColumn::setDateFormat()
     * @covers Cocur\Arff\Column\DateColumn::getDateFormat()
     */
    public function setDateFormatsSetsDateFormatAndGetDateFormatReturnsDateFormat()
    {
        $column = new DateColumn('foo');
        $column->setDateFormat('yyyy-MM-dd HH:mm:ss');

        $this->assertEquals('foo', $column->getName());
        $this->assertEquals('yyyy-MM-dd HH:mm:ss', $column->getDateFormat());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\DateColumn::__construct()
     */
    public function constructorSetsNameAndDateFormat()
    {
        $column = new DateColumn('foo', 'yyyy-MM-dd HH:mm:ss');

        $this->assertEquals('foo', $column->getName());
        $this->assertEquals('yyyy-MM-dd HH:mm:ss', $column->getDateFormat());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\DateColumn::render()
     */
    public function renderRendersAttribute()
    {
        $column = new DateColumn('foo');

        $this->assertEquals('@ATTRIBUTE foo date', $column->render());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\DateColumn::render()
     */
    public function renderRendersAttributeWithDateFormat()
    {
        $column = new DateColumn('foo', 'yyyy-MM-dd HH:mm:ss');

        $this->assertEquals('@ATTRIBUTE foo date "yyyy-MM-dd HH:mm:ss"', $column->render());
    }
}

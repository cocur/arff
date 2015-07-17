<?php


namespace Cocur\Arff\Column;
use PHPUnit_Framework_TestCase;

/**
 * NominalColumnTest
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class NominalColumnTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers Cocur\Arff\Column\NominalColumn::getType()
     */
    public function getTypeReturnsString()
    {
        $this->assertEquals('nominal', (new NominalColumn())->getType());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\AbstractColumn::setName()
     * @covers Cocur\Arff\Column\AbstractColumn::getName()
     */
    public function setNameSetsNameAndGetNameReturnsName()
    {
        $column = new NominalColumn();
        $column->setName('foo');

        $this->assertEquals('foo', $column->getName());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\NominalColumn::setClasses()
     * @covers Cocur\Arff\Column\NominalColumn::getClasses()
     */
    public function setClassesSetsClassesAndGetClassesReturnsClasses()
    {
        $column = new NominalColumn();
        $column->setClasses(['a', 'b', 'c']);

        $this->assertCount(3, $column->getClasses());
        $this->assertContains('a', $column->getClasses());
        $this->assertContains('b', $column->getClasses());
        $this->assertContains('c', $column->getClasses());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\NominalColumn::__construct()
     */
    public function constructorSetsNameAndClasses()
    {
        $column = new NominalColumn('foo', ['a', 'b', 'c']);

        $this->assertEquals('foo', $column->getName());
        $this->assertCount(3, $column->getClasses());
        $this->assertContains('a', $column->getClasses());
        $this->assertContains('b', $column->getClasses());
        $this->assertContains('c', $column->getClasses());
    }

    /**
     * @test
     * @covers Cocur\Arff\Column\NominalColumn::render()
     */
    public function renderRendersAttribute()
    {
        $column = new NominalColumn('foo', ['a', 'b', 'c']);

        $this->assertEquals('@ATTRIBUTE foo {a,b,c}', $column->render());
    }
}

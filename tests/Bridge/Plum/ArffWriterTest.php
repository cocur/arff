<?php

namespace Cocur\Arff\Bridge\Plum;

use Cocur\Arff\Column\NumericColumn;
use Cocur\Arff\Column\StringColumn;
use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_TestCase;

/**
 * ArffWriterTest
 *
 * @package   Cocur\Arff\Bridge\Plum
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class ArffWriterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers Cocur\Arff\Bridge\Plum\ArffWriter::prepare()
     */
    public function prepareWritesHeader()
    {
        $root = vfsStream::setup();
        $writer = new ArffWriter($root->url().'/data.arff', 'data', [
            new StringColumn('foo'),
            new NumericColumn('bar'),
        ]);

        $writer->prepare();

        $this->assertStringStartsWith('@RELATION data', $root->getChild('data.arff')->getContent());
    }
    /**
     * @test
     * @covers Cocur\Arff\Bridge\Plum\ArffWriter::writeItem()
     */
    public function writeItemWritesItem()
    {
        $root = vfsStream::setup();
        $writer = new ArffWriter($root->url().'/data.arff', 'data', [
            new StringColumn('foo'),
            new NumericColumn('bar'),
        ]);

        $writer->prepare();
        $writer->writeItem(['foo' => 'hello', 'bar' => 0.5]);

        $this->assertStringEndsWith("hello,0.5\n", $root->getChild('data.arff')->getContent());
    }

    /**
     * @test
     * @covers Cocur\Arff\Bridge\Plum\ArffWriter::finish()
     */
    public function finishDoesNothing()
    {
        $writer = new ArffWriter('foo.txt', 'foo', []);
        $writer->finish();
    }
}

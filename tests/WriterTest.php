<?php

namespace Cocur\Arff;

use Mockery;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

require_once 'ArffMock.php';

/**
 * ArffWriterTest.
 *
 * @author    Florian Eckerstorfer
 * @copyright 2015-2017 Florian Eckerstorfer
 * @group     unit
 */
class WriterTest extends TestCase
{
    /**
     * @test
     * @covers \Cocur\Arff\Writer::renderRow()
     * @covers \Cocur\Arff\Writer::render()
     */
    public function renderRendersArffFileAndWritesThemDoDisk()
    {
        $document = mockArffDocument();
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

        $writer = new Writer();

        $this->assertEquals($expected, $writer->render($document));
    }

    /**
     * @test
     * @covers \Cocur\Arff\Writer::write()
     */
    public function writeWritesArffFileToDisk()
    {
        $root = vfsStream::setup('fixtures');

        $document = mockArffDocument();
        $writer = new Writer();
        $writer->write($document, $root->url().'/data.arff');

        $this->assertTrue($root->hasChild('data.arff'));
    }
}

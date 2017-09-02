<?php

namespace Cocur\Arff;

use Cocur\Arff\Column\DateColumn;
use Cocur\Arff\Column\NominalColumn;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    /**
     * @test
     * @covers \Cocur\Arff\Reader::readFile()
     */
    public function readRelationName()
    {
        $reader = new Reader();
        $root = vfsStream::setup('fixtures');
        $content = <<<EOF
@RELATION foobar

@ATTRIBUTE a string
@ATTRIBUTE b numeric
@ATTRIBUTE c {x,y,'Top 100 Editors Picks: Print Books: Books'}
@ATTRIBUTE d date "yyyy-MM-dd HH:mm:ss"

@DATA
hello,1.5,x,'2015-07-17 16:12:30'
'hello world',1.5,'x y',?
hello,?,z,?
'hello,world',?,?,?
'hello;world',?,?,?

EOF;
        $file = new vfsStreamFile('test.arff', 0777);
        $file->setContent($content);
        $root->addChild($file);
        $document = $reader->readFile($root->url().'/test.arff');

        $columns = $document->getColumns();
        $this->assertEquals('foobar', $document->getName());

        $this->assertEquals('a', $columns['a']->getName());
        $this->assertEquals('string', $columns['a']->getType());

        $this->assertEquals('b', $columns['b']->getName());
        $this->assertEquals('numeric', $columns['b']->getType());

        /** @var NominalColumn $columnC */
        $columnC = $columns['c'];
        $this->assertEquals('c', $columnC->getName());
        $this->assertEquals('nominal', $columnC->getType());
        $this->assertEquals('x', $columnC->getClasses()[0]);
        $this->assertEquals('y', $columnC->getClasses()[1]);
        $this->assertEquals('Top 100 Editors Picks: Print Books: Books', $columnC->getClasses()[2]);

        /** @var DateColumn $columnD */
        $columnD = $columns['d'];
        $this->assertEquals('d', $columnD->getName());
        $this->assertEquals('date', $columnD->getType());
        $this->assertEquals('yyyy-MM-dd HH:mm:ss', $columnD->getDateFormat());

        $data = $document->getData();
        $this->assertEquals('hello', $data[0]['a']);
        $this->assertEquals(1.5, $data[0]['b']);
        $this->assertEquals('x', $data[0]['c']);
        $this->assertEquals('2015-07-17 16:12:30', $data[0]['d']);

        $this->assertEquals('hello world', $data[1]['a']);
        $this->assertEquals('1.5', $data[1]['b']);
        $this->assertEquals('x y', $data[1]['c']);
        $this->assertEquals('?', $data[1]['d']);

        $this->assertEquals('hello', $data[2]['a']);
        $this->assertEquals('?', $data[2]['b']);
        $this->assertEquals('z', $data[2]['c']);
        $this->assertEquals('?', $data[2]['d']);

        $this->assertEquals('hello,world', $data[3]['a']);
        $this->assertEquals('hello;world', $data[4]['a']);
    }
}

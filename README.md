cocur/arff
==========

> Read and write `.arff` files for Weka.

[![Build Status](https://travis-ci.org/cocur/arff.svg?branch=master)](https://travis-ci.org/cocur/arff)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cocur/arff/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cocur/arff/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/cocur/arff/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cocur/arff/?branch=master)

Developed by [Florian Eckerstorfer](https://florian.ec) in Vienna, Europe.

Installation
------------

You can install `cocur/arff` with [Composer](http://getcomposer.org):

```shell
$ composer require cocur/arff
```

Usage
-----

### Write `.arff` file

```php
use Cocur\Arff\Document;
use Cocur\Arff\Column\NumericColumn;
use Cocur\Arff\Column\NominalColumn;

$document = new Document('iris');
$document->addColumn(new NumericColumn('sepallength'));
$document->addColumn(new NumericColumn('sepalwidth'));
$document->addColumn(new NumericColumn('petallength'));
$document->addColumn(new NumericColumn('petalwidth'));
$document->addColumn(new NominalColumn('class', ['Iris-setosa','Iris-versicolor','Iris-virginica']));

$document->addData(['sepallength' => 5.1, 'sepalwidth' => 3.5, 'petallength' => 1.4, 'petalwidth' => 0.2, 'class' => 'Iris-setosa']);

$writer = new Writer();

$writer->render($document);           // returns rendered .arff file
$writer->write($document, 'iris.arff'); // writes .arff file to disk
```

### Read `.arff` file

```php
use Cocur\Arff\Reader;

$reader = new Reader();
$document = $reader->readFile('irif.arff'); // returns Cocur\Arff\Document
```

#### Available types of columns

- `Cocur\Arff\Column\NumericColumn`
- `Cocur\Arff\Column\StringColumn`
- `Cocur\Arff\Column\NominalColumn`
- `Cocur\Arff\Column\DateColumn`

#### Date columns

You can define the date format for date columns. The format is only used to write to the Arff file, you need to
convert the date manually before adding the data.

```php
$column = new DateColumn('created', 'yyyy-MM-dd HH:mm:ss');
```

### Plum Integration

cocur/arff contains a writer for [Plum](https://github.com/plumphp/plum).

```php
use Cocur\Arff\Bridge\Plum\ArffWriter;

$writer = new ArffWriter('filename.arff', 'name', [
    new NumericColumn('sepallength'),
    new NumericColumn('sepalwidth'),
    new NumericColumn('petallength'),
    new NumericColumn('petalwidth'),
    new NominalColumn('class', ['Iris-setosa','Iris-versicolor','Iris-virginica']),
]);
```

Changelog
---------

### Version 0.2.3 (7 September 2018)

- [#3](https://github.com/cocur/arff/pull/3) Support more generic relation name and drops malformed lines (by [frantzmiccoli](https://github.com/frantzmiccoli))

### Version 0.2.2 (16 March 2018)

- Case-insensitive parsing of column type

### Version 0.2.1 (2 September 2017)

- Fix parsing of nominal columns

### Version 0.2 (2 September 2017)

- Split `ArffFile` into `Cocur\Arff\Document` and `Cocur\Arff\Writer`
- Add `Cocur\Arff\Reader` to read `.arff` files

### Version 0.1 (17 July 2015)

- Initial release


License
--------

The MIT license applies to cocur/arff. For the full copyright and license information, please view the LICENSE file
distributed with this source code.


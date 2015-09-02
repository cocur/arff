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
use Cocur\Arff\ArffFile;
use Cocur\Arff\Column\NumericColumn;
use Cocur\Arff\Column\NominalColumn;

$file = new ArffFile('iris');
$file->addColumn(new NumericColumn('sepallength'));
$file->addColumn(new NumericColumn('sepalwidth'));
$file->addColumn(new NumericColumn('petallength'));
$file->addColumn(new NumericColumn('petalwidth'));
$file->addColumn(new NominalColumn('class', ['Iris-setosa','Iris-versicolor','Iris-virginica']));

$file->addData(['sepallength' => 5.1, 'sepalwidth' => 3.5, 'petallength' => 1.4, 'petalwidth' => 0.2, 'class' => 'Iris-setosa']);

$file->render();           // returns rendered .arff file
$file->write('iris.arff'); // writes .arff file to disk
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

### Version 0.1 (17 July 2015)

- Initial release


License
--------

The MIT license applies to cocur/arff. For the full copyright and license information, please view the LICENSE file
distributed with this source code.


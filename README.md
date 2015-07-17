cocur/arff
==========

> Read and write `.arff` files for Weka.

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

$file = new ArffFile('iris');
$file->addColumn(new NumericColumn('sepallength'));
$file->addColumn(new NumericColumn('sepalwidth'));
$file->addColumn(new NumericColumn('petallength'));
$file->addColumn(new NumericColumn('petalwidth'));
$file->addColumn(new NominalColumn('class', ['Iris-setosa','Iris-versicolor','Iris-virginica']));

$file->addData(['sepallength' => 5.1, 'sepalwidth' => 3.5, 'petallength' => 1.4, 'petalwidth' => 0.2, 'class' => Iris-setosa']);

$file->render();           // returns rendered .arff file
$file->write('iris.arff'); // writes .arff file to disk
```

#### Available types of columns

- `NumericColumn`
- `StringColumn`
- `NominalColumn`
- `DateColumn`

#### Date columns

You can define the date format for date columns. The format is only used to write to the Arff file, you need to
convert the date manually before adding the data.

```php
$column = new DateColumn('created', 'yyyy-MM-dd HH:mm:ss');
```


License
--------

The MIT license applies to cocur/arff. For the full copyright and license information, please view the LICENSE file
distributed with this source code.


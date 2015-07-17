<?php


namespace Cocur\Arff\Column;

/**
 * NominalColumn
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
class NominalColumn extends AbstractColumn
{
    /**
     * @var string[]
     */
    protected $classes = [];

    /**
     * @param string|null $name
     * @param string[]    $classes
     */
    public function __construct($name = null, array $classes = [])
    {
        if ($name) {
            $this->setName($name);
        }
        $this->setClasses($classes);
    }

    /**
     * @param string[] $classes
     *
     * @return NominalColumn
     */
    public function setClasses(array $classes)
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'nominal';
    }

    /**
     * @return string
     */
    public function render()
    {
        return sprintf('@ATTRIBUTE %s {%s}', $this->getName(), implode(',', $this->getClasses()));
    }
}

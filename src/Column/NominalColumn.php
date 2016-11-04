<?php

namespace Cocur\Arff\Column;

/**
 * NominalColumn.
 *
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
        if ($name !== null) {
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
        return sprintf('@ATTRIBUTE %s {%s}', $this->getName(), $this->renderClasses());
    }
    
    /**
     * @return string
     */
    private function renderClasses()
    {
        $classes = $this->getClasses();
        $strClass = '';

        for ($i = 0; $i < count($classes); ++$i) {
            $class = $classes[$i];

            if (preg_match('/\s|,|;/', $class)) {
                $class = sprintf("'%s'", $class);
            }
            $classes[$i] = $class;
        }

        return implode(',', $classes);
    }
}

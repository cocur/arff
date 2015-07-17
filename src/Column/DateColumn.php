<?php

namespace Cocur\Arff\Column;

/**
 * DateColumn
 *
 * @package   Cocur\Arff\Column
 * @author    Florian Eckerstorfer
 * @copyright 2015 Florian Eckerstorfer
 */
class DateColumn extends AbstractColumn
{
    /**
     * @var string
     */
    protected $dateFormat;

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @param string $dateFormat
     *
     * @return DateColumn
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }

    /**
     * @param string|null $name
     * @param string|null $dateFormat
     */
    public function __construct($name = null, $dateFormat = null)
    {
        if ($name !== null) {
            $this->setName($name);
        }
        $this->dateFormat = $dateFormat;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'date';
    }

    /**
     * @return string
     */
    public function render()
    {
        $dateFormat = $this->getDateFormat();
        if ($dateFormat !== null) {
            $dateFormat = sprintf(' "%s"', $dateFormat);
        }

        return parent::render().$dateFormat;
    }
}

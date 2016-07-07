<?php
/**
 * core42 (www.raum42.at)
 *
 * @link http://www.raum42.at
 * @copyright Copyright (c) 2010-2014 raum42 OG (http://www.raum42.at)
 *
 */

namespace Core42\Hydrator\Strategy\Database\MySQL;

use Core42\Hydrator\Strategy\Database\DatabaseStrategyInterface;
use Zend\Hydrator\Strategy\StrategyInterface;

class FloatStrategy implements StrategyInterface, DatabaseStrategyInterface
{
    /**
     * @param  \Zend\Db\Metadata\Object\ColumnObject $column
     * @return mixed
     */
    public function isResponsible(\Zend\Db\Metadata\Object\ColumnObject $column)
    {
        return (in_array($column->getDataType(), ['decimal', 'numeric', 'float', 'double']));
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param mixed $value The original value.
     * @internal param object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     */
    public function extract($value)
    {
        return (float) $value;
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param mixed $value The original value.
     * @internal param array $data (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     */
    public function hydrate($value)
    {
        return (float) $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Float';
    }
}
<?php
namespace Core42\Hydrator\Strategy\Database\MySQL;

use Core42\Hydrator\Strategy\Database\DatabaseStrategyInterface;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DateStrategy implements StrategyInterface, DatabaseStrategyInterface
{
    /**
     * @var boolean
     */
    private $isNullable;

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param mixed $value The original value.
     * @internal param object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     */
    public function extract($value)
    {
        if ($this->isNullable && $value === null) return null;

        if ($value instanceof \DateTime) {
            return date("Y-m-d", $value->getTimestamp());
        }

        return $value;
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
        if ($this->isNullable && $value === null) return null;
        return new \DateTime($value);
    }

    /**
     * @param  \Zend\Db\Metadata\Object\ColumnObject $column
     * @return mixed
     */
    public function getStrategy(\Zend\Db\Metadata\Object\ColumnObject $column)
    {
        $this->isNullable = $column->getIsNullable();

        return (in_array($column->getDataType(), array('date'))) ? $this : null;
    }
}
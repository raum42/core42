<?php
/**
 * core42 (www.raum42.at)
 *
 * @link http://www.raum42.at
 * @copyright Copyright (c) 2010-2014 raum42 OG (http://www.raum42.at)
 *
 */

namespace Core42\Hydrator\Strategy\Database;

interface DatabaseStrategyInterface
{
    /**
     * @param \Zend\Db\Metadata\Object\ColumnObject $column
     * @return boolean
     */
    public function isResponsible(\Zend\Db\Metadata\Object\ColumnObject $column);

    /**
     * @return string
     */
    public function getName();
}
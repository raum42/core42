<?php
/**
 * core42 (www.raum42.at)
 *
 * @link http://www.raum42.at
 * @copyright Copyright (c) 2010-2014 raum42 OG (http://www.raum42.at)
 *
 */

namespace Core42\Hydrator\Strategy\Json;

use Zend\Hydrator\Strategy\StrategyInterface;

class DateTimeStrategy implements StrategyInterface
{
    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param mixed $value The original value.
     * @internal param object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     */
    public function extract($value)
    {
        if ($value instanceof \DateTime) {
            return [
                '@type'    => \DateTime::class,
                'datetime' => $value->format('Y-m-d H:i:s'),
                'timezone' => $value->getTimezone()->getName(),
            ];
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
        $return = $value;
        if (is_array($value) && isset($value['@type']) && isset($value['datetime']) && isset($value['timezone'])) {
            $return = new \DateTime($value['datetime'], new \DateTimeZone($value['timezone']));
        }

        return $return;
    }
}
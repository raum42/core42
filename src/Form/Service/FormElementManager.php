<?php

/*
 * core42
 *
 * @package core42
 * @link https://github.com/kiwi-suite/core42
 * @copyright Copyright (c) 2010 - 2017 kiwi suite (https://www.kiwi-suite.com)
 * @license MIT License
 * @author kiwi suite <dev@kiwi-suite.com>
 */

namespace Core42\Form\Service;

use Zend\Form\FormElementManager\FormElementManagerV3Polyfill;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

class FormElementManager extends FormElementManagerV3Polyfill
{
    protected $aliases = [];

    /**
     * Factories for default set of helpers
     *
     * @var array
     */
    protected $factories = [];

    /**
     * @param string $name
     * @param null $class
     */
    public function setInvokableClass($name, $class = null)
    {
        $class = $class ?: $name;

        if (!$this->has($class)) {
            $this->setFactory($class, ElementFactory::class);
        }

        if ($class === $name) {
            return;
        }

        $this->setAlias($name, $class);
    }

    /**
     * @param string $name
     * @param array $options
     * @param bool $usePeeringServiceManagers
     * @return object
     */
    public function get($name, $options = [], $usePeeringServiceManagers = true)
    {
        if (!$this->has($name)) {
            if (!$this->autoAddInvokableClass || !\class_exists($name)) {
                throw new ServiceNotCreatedException(\sprintf(
                    'A plugin by the name "%s" was not found in the plugin manager %s',
                    $name,
                    \get_class($this)
                ));
            }

            $this->setInvokableClass($name);
        }

        return parent::get($name, $options, $usePeeringServiceManagers);
    }
}

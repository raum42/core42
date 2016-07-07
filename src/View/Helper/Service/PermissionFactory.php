<?php
/**
 * core42 (www.raum42.at)
 *
 * @link http://www.raum42.at
 * @copyright Copyright (c) 2010-2014 raum42 OG (http://www.raum42.at)
 *
 */

namespace Core42\View\Helper\Service;

use Core42\View\Helper\Permission;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PermissionFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return Permission
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Permission($container->get('Permission'));
    }
}

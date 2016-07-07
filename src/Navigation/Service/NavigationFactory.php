<?php
/**
 * core42 (www.raum42.at)
 *
 * @link http://www.raum42.at
 * @copyright Copyright (c) 2010-2014 raum42 OG (http://www.raum42.at)
 *
 */

namespace Core42\Navigation\Service;

use Core42\Navigation\Navigation;
use Core42\Navigation\Options\NavigationOptions;
use Interop\Container\ContainerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class NavigationFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return Navigation
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var NavigationOptions $options */
        $options = $container->get(NavigationOptions::class);

        $navigation = new Navigation();
        $navigation->setServiceManager($container);

        foreach ($options->getListeners() as $navName => $_listener) {
            foreach ($_listener as $priority => $listener) {
                if (is_string($listener)) {
                    if ($container->has($listener)) {
                        $listener = $container->get($listener);
                    } else {
                        $listener = new $listener();
                    }
                }
                /* @var ListenerAggregateInterface $listener */

                if (is_numeric($priority)) {
                    $listener->attach($navigation->getEventManager($navName), $priority);
                } else {
                    $listener->attach($navigation->getEventManager($navName));
                }
            }
        }

        $application = $container->get('Application');
        $routeMatch  = $application->getMvcEvent()->getRouteMatch();
        $router      = $application->getMvcEvent()->getRouter();

        $navigation->setRouteMatch($routeMatch);
        $navigation->setRouter($router);

        return $navigation;
    }
}
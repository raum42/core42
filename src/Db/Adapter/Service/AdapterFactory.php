<?php
namespace Core42\Db\Adapter\Service;

use BjyProfiler\Db\Adapter\ProfilingAdapter;
use BjyProfiler\Db\Profiler\Profiler;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AdapterFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        if (!isset($config['db']['adapters'][$requestedName])) {
            throw new ServiceNotCreatedException("Can't create DB Adapter with name {$requestedName}");
        }
        $config = $config['db']['adapters'][$requestedName];


        if (DEVELOPMENT_MODE === true && php_sapi_name() !== 'cli' && class_exists(ProfilingAdapter::class)) {
            $adapter = new ProfilingAdapter($config);
            $adapter->setProfiler(new Profiler());

            $options = [];
            if (isset($config['options']) && is_array($config['options'])) {
                $options = $config['options'];
            }

            $adapter->injectProfilingStatementPrototype($options);
            return $adapter;
        }

        return new Adapter($config);
    }
}

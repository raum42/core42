<?php
namespace Core42;

return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Core42\Db\Adapter\AdapterAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
            'Core42\Queue\Service\QueueAbstractFactory',
        ),
        'factories' => array(
            'Zend\Session\Service\SessionManager'           => 'Zend\Session\Service\SessionManagerFactory',
            'Zend\Session\Config\ConfigInterface'           => 'Zend\Session\Service\SessionConfigFactory',
            'Zend\Session\Storage\StorageInterface'         => 'Zend\Session\Service\StorageFactory',

            'Core42\Mail\Transport'                         => 'Core42\Mail\Transport\Service\TransportFactory',

            'Core42\CommandPluginManager'                   => 'Core42\Command\Service\CommandPluginManagerFactory',
            'Core42\TableGatewayPluginManager'              => 'Core42\Db\TableGateway\Service\TableGatewayPluginManagerFactory',
            'Core42\HydratorStrategyPluginManager'          => 'Core42\Hydrator\Strategy\Service\HydratorStrategyPluginManagerFactory',
            'Core42\SelectorPluginManager'                  => 'Core42\Selector\Service\SelectorPluginManagerFactory',
            'Core42\QueueAdapterPluginManager'              => 'Core42\Queue\Service\AdapterPluginManagerFactory',
            'Core42\FormPluginManager'                      => 'Core42\Form\Service\FormPluginManagerFactory',

            'Core42\Form\ThemeManager'                      => 'Core42\Form\Theme\Service\ThemeManagerFactory',

            'Metadata'                                      => 'Core42\Db\Metadata\Service\MetadataServiceFactory',

            'TreeRouteMatcher'                              => 'Core42\Mvc\TreeRouteMatcher\Service\TreeRouteMatcherFactory',

            'Core42\Rbac'                                   => 'Core42\Permission\Rbac\Service\RbacFactory',
            'Core42\Permission'                             => 'Core42\Permission\Rbac\Service\RbacManagerFactory',
            'Core42\Permission\RoleProviderPluginManager'   => 'Core42\Permission\Rbac\Service\RoleProviderPluginManagerFactory',
            'Core42\Permission\GuardPluginManager'          => 'Core42\Permission\Rbac\Service\GuardPluginManagerFactory',
            'Core42\Permission\AssertionPluginManager'      => 'Core42\Permission\Rbac\Service\AssertionPluginManagerFactory',
            'Core42\Permission\RedirectStrategy'            => 'Core42\Permission\Rbac\Service\RedirectStrategyFactory',
            'Core42\Permission\UnauthorizedStrategy'        => 'Core42\Permission\Rbac\Service\UnauthorizedStrategyFactory',

            'Core42\NavigationOptions'                      => 'Core42\Navigation\Service\NavigationOptionsFactory',
            'Core42\Navigation'                             => 'Core42\Navigation\Service\NavigationFactory',

            'MvcTranslator'                                 => 'Core42\I18n\Translator\Service\TranslatorFactory',
            'MvcTranslatorPluginManager'                    => 'Core42\I18n\Translator\Service\TranslatorLoaderFactory',
        ),
        'invokables' => array(
            'MobileDetect'                                  => '\Mobile_Detect',

            'Core42\LoggingProfiler'                        => 'Core42\Db\Adapter\Profiler\LoggingProfiler',

            'Core42\ConsoleDispatcher'                      => 'Core42\Command\Console\ConsoleDispatcher',

            'Core42\TransactionManager'                     => 'Core42\Db\Transaction\TransactionManager',
        ),
        'aliases' => array(
            'TransactionManager'                            => 'Core42\TransactionManager',

            'Command'                                       => 'Core42\CommandPluginManager',
            'TableGateway'                                  => 'Core42\TableGatewayPluginManager',
            'HydratorStrategy'                              => 'Core42\HydratorStrategyPluginManager',
            'Selector'                                      => 'Core42\SelectorPluginManager',
            'QueueAdapter'                                  => 'Core42\QueueAdapterPluginManager',
            'Form'                                          => 'Core42\FormPluginManager',

            'Navigation'                                    => 'Core42\Navigation'
        ),
    ),

    'table_gateway' => array(
        'factories' => array(
            'Core42\Migration' => 'Core42\TableGateway\Service\MigrationTableGatewayFactory'
        ),
    ),
);

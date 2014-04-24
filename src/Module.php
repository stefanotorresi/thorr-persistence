<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence;

use Zend\ModuleManager\Feature;
use Zend\ModuleManager\Listener\ServiceListenerInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ServiceManager\ServiceManager;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\ConfigProviderInterface,
    Feature\InitProviderInterface,
    Feature\ServiceProviderInterface,
    Repository\Manager\RepositoryManagerConfigProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function init(ModuleManagerInterface $moduleManager)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $moduleManager->getEvent()->getParam('ServiceManager');

        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $serviceManager->get('ServiceListener');

        $serviceListener->addServiceManager(
            'Thorr\Persistence\Repository\Manager\RepositoryManager',
            'repository_manager',
            'Thorr\Persistence\Repository\Manager\RepositoryManagerConfigProviderInterface',
            'getRepositoryManagerConfig'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/../autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return [
            /**
             * Doctrine mappings for Entity\AbstractEntity
             */
            'doctrine' => [
                'driver' => [
                    __NAMESPACE__ => [
                        'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                        'paths' => __DIR__ . '/../config',
                    ],
                    'orm_default' =>[
                        'drivers' => [
                            __NAMESPACE__ . '\Entity' => __NAMESPACE__
                        ]
                    ]
                ]
            ],
        ];
    }

    public function getRepositoryManagerConfig()
    {
        return [
            'abstract_factories' => [
                'Thorr\Persistence\Doctrine\Repository\AbstractRepositoryFactory'
            ]
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'Thorr\Persistence\Repository\Manager\RepositoryManager' =>
                    'Thorr\Persistence\Repository\Manager\RepositoryManagerFactory'
            ],
            'aliases' => [
                'RepositoryManager' => 'Thorr\Persistence\Repository\Manager\RepositoryManager'
            ]
        ];
    }
}

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
    Feature\InitProviderInterface,
    Feature\ServiceProviderInterface
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
            DataMapper\Manager\DataMapperManager::class,
            'thorr_persistence_dmm',
            DataMapper\Manager\DataMapperManagerConfigProviderInterface::class,
            'getDataMapperManagerConfig'
        );
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
                DataMapper\Manager\DataMapperManager::class => DataMapper\Manager\DataMapperManagerFactory::class,
            ],
            'aliases' => [
                'DataMapperManager' => DataMapper\Manager\DataMapperManager::class,
            ],
        ];
    }
}

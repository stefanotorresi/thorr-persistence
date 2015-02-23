<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper\Manager;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DataMapperManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DataMapperManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $dmmConfig = isset($config['thorr_persistence_dmm'])
            ? new DataMapperManagerConfig($config['thorr_persistence_dmm'])
            : null;

        $dataMapperManager = new DataMapperManager($dmmConfig);
        $dataMapperManager->setServiceLocator($serviceLocator);

        if (isset($config['di']) && $serviceLocator->has('Di')) {
            $dataMapperManager->addAbstractFactory($serviceLocator->get('DiAbstractServiceFactory'));
        }

        return $dataMapperManager;
    }
}

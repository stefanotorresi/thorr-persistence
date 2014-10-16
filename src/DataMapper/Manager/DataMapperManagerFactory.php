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
     * @param  ServiceLocatorInterface $serviceLocator
     * @return DataMapperManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dataMapperManager = new DataMapperManager();
        $dataMapperManager->setServiceLocator($serviceLocator);

        $configuration = $serviceLocator->get('Config');

        if (isset($configuration['di']) && $serviceLocator->has('Di')) {
            $dataMapperManager->addAbstractFactory($serviceLocator->get('DiAbstractServiceFactory'));
        }

        return $dataMapperManager;
    }
}

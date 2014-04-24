<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Repository\Manager;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RepositoryManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return RepositoryManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $repositoryManager = new RepositoryManager();
        $repositoryManager->setServiceLocator($serviceLocator);

        $configuration = $serviceLocator->get('Config');

        if (isset($configuration['di']) && $serviceLocator->has('Di')) {
            $repositoryManager->addAbstractFactory($serviceLocator->get('DiAbstractServiceFactory'));
        }

        return $repositoryManager;
    }
}

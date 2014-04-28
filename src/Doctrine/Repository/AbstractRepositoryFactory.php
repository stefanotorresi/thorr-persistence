<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Doctrine\Repository;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\InvalidServiceNameException;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractRepositoryFactory implements AbstractFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $serviceManager = $serviceLocator instanceof AbstractPluginManager ?
            $serviceLocator->getServiceLocator() : $serviceLocator;

        if (! $serviceManager->has('Doctrine\ORM\EntityManager')) {
            return false;
        }

        $config = $serviceManager->get('config');

        if (! isset($config['repository_manager']['repositories'])) {
            return false;
        }

        return in_array($requestedName, $config['repository_manager']['repositories']);
    }

    /**
     * {@inheritdoc}
     * @throws InvalidServiceNameException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $serviceManager = $serviceLocator instanceof AbstractPluginManager ?
            $serviceLocator->getServiceLocator() : $serviceLocator;

        $config = $serviceManager->get('config');

        $entityClass = array_search($requestedName, $config['repository_manager']['repositories']);

        /** @var ObjectManager $objectManager */
        $objectManager = $serviceManager->get('Doctrine\ORM\EntityManager');

        return $objectManager->getRepository($entityClass);
    }
}

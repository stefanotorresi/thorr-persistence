<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractPluginManager;

class EntityManagerAwareInitializer implements InitializerInterface
{
    /**
     * {@inheritDoc}
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if (! $instance instanceof EntityManagerAwareInterface) {
            return;
        }

        $serviceManager = $serviceLocator instanceof AbstractPluginManager ?
            $serviceLocator->getServiceLocator() : $serviceLocator;

        /* @var $entityManager EntityManager */
        $entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');

        $instance->setEntityManager($entityManager);
    }
}

<?php

/**
 * Copyright (c) 2013 Stefano Torresi (http://stefanotorresi.it)
 * See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace MyBase\Doctrine;

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

        $serviceManager = ( $serviceLocator instanceof AbstractPluginManager ) ?
            $serviceLocator->getServiceLocator () : $serviceLocator;

        /* @var $objectManager EntityManager */
        $objectManager = $serviceManager->get('Doctrine\ORM\EntityManager');

        $instance->setEntityManager($objectManager);
    }

}

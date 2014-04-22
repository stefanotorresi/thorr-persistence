<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence;

use Zend\ModuleManager\Feature;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\ConfigProviderInterface
{
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
             * Doctrine mappings for Entity\BaseEntity
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
}

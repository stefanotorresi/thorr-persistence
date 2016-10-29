<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\DataMapper\Manager;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\Test\Asset;
use Thorr\Persistence\DataMapper\DataMapperInterface;
use Thorr\Persistence\DataMapper\Manager\DataMapperManager;
use Thorr\Persistence\DataMapper\Manager\DataMapperManagerFactory;
use Zend\ServiceManager\Di\DiAbstractServiceFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class DataMapperManagerFactoryTest extends TestCase
{
    public function testCreateService()
    {
        $factory        = new DataMapperManagerFactory();
        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);

        $dataMapperManager = $factory->createService($serviceLocator);

        $this->assertInstanceOf(DataMapperManager::class, $dataMapperManager);
    }

    public function testDISupport()
    {
        $factory           = new DataMapperManagerFactory();
        $serviceLocator    = $this->getMock(ServiceLocatorInterface::class);
        $diAbstractFactory = $this->getMockBuilder(DiAbstractServiceFactory::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();

        $serviceLocator->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(function ($arg) use ($diAbstractFactory) {
                switch ($arg) {
                    case 'Config': return [ 'di' => [] ];
                    case 'DiAbstractServiceFactory': return $diAbstractFactory;
                }
            });

        $serviceLocator->expects($this->atLeastOnce())
            ->method('has')
            ->with('Di')
            ->willReturn(true);

        $dataMapperManager = $factory->createService($serviceLocator);

        $this->assertAttributeContains($diAbstractFactory, 'abstractFactories', $dataMapperManager);
    }

    public function testCreateServiceWithConfig()
    {
        $factory        = new DataMapperManagerFactory();
        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);
        $dataMapper     = $this->getMock(DataMapperInterface::class);
        $dataMapper->expects($this->any())->method('getEntityClass')->willReturn(Asset\Entity::class);

        $serviceLocator
            ->expects($this->any())
            ->method('get')
            ->with('Config')
            ->willReturn([
                'thorr_persistence_dmm' => [
                    'services' => [
                        'foo' => $dataMapper
                    ]
                ]
            ])
        ;

        $dataMapperManager = $factory->createService($serviceLocator);

        $this->assertInstanceOf(DataMapperManager::class, $dataMapperManager);

        $this->assertSame($dataMapper, $dataMapperManager->get('foo'));
    }
}

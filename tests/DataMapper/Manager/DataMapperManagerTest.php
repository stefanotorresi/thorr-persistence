<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\DataMapper\Manager;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\DataMapper\DataMapperInterface;
use Thorr\Persistence\DataMapper\Manager\DataMapperManager;
use Thorr\Persistence\DataMapper\Manager\DataMapperManagerConfig;
use Zend\ServiceManager\Exception\InvalidArgumentException;
use Zend\ServiceManager\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorInterface;

class DataMapperManagerTest extends TestCase
{
    /**
     * @param mixed $dataMapper
     * @param array $expectedException
     * @dataProvider validatePluginProvider
     */
    public function testValidatePlugin($dataMapper, $expectedException)
    {
        $dataMapperManager = new DataMapperManager();

        if (is_callable($dataMapper)) {
            $dataMapper = $dataMapper();
        }

        if ($expectedException) {
            $this->setExpectedException($expectedException[0], $expectedException[1]);
        }

        $dataMapperManager->validatePlugin($dataMapper);
    }

    public function validatePluginProvider()
    {
        return [
            [
                // $dataMapper
                new \stdClass(),
                // $expectedException
                [RuntimeException::class, 'Invalid DataMapper type'],
            ],
            [
                // $dataMapper
                $this->getMock(DataMapperInterface::class),
                // $expectedException
                [RuntimeException::class, 'getEntityClass() must return a non empty value'],
            ],
            [
                // $dataMapper
                function () {
                    $mock = $this->getMock(DataMapperInterface::class);
                    $mock->expects($this->any())->method('getEntityClass')->willReturn('foo');

                    return $mock;
                },
                // $expectedException
                null,
            ],
        ];
    }

    /**
     * @param array $config
     * @param $requestedDataMapperEntity
     * @param bool  $expectedException
     * @dataProvider configProvider
     */
    public function testGetDataMapperForEntity($config, $requestedDataMapperEntity, $expectedException)
    {
        $dataMapperManager = new DataMapperManager(new DataMapperManagerConfig($config));

        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);
        $serviceLocator->expects($this->any())
                        ->method('get')
                        ->with('config')
                        ->willReturn($config);

        $dataMapperManager->setServiceLocator($serviceLocator);

        if ($expectedException) {
            $this->setExpectedException($expectedException);
            $dataMapperManager->getDataMapperForEntity($requestedDataMapperEntity);

            return;
        }

        $dataMapper = $dataMapperManager->getDataMapperForEntity($requestedDataMapperEntity);
        $this->assertInstanceOf(DataMapperInterface::class, $dataMapper);
    }

    /**
     * @see testGetDataMapperForEntity()
     *
     * @return array
     */
    public function configProvider()
    {
        return [
            [
                // $config
                [],

                // $requestedDataMapperEntity
                'anything',

                // $expectedException
                InvalidArgumentException::class,
            ],
            [
                // $config
                [
                    'entity_data_mapper_map' => [],
                ],

                // $requestedDataMapperEntity
                'anything',

                // $expectedException
                InvalidArgumentException::class,
            ],
            [
                // $config
                [
                    'entity_data_mapper_map' => [
                        'SomeEntityClass' => 'SomeDataMapperServiceName',
                    ],
                    'factories' => [
                        'SomeDataMapperServiceName' => function () {
                            $mock = $this->getMock(DataMapperInterface::class);
                            $mock->expects($this->any())->method('getEntityClass')->willReturn('SomeEntityClass');

                            return $mock;
                        },
                    ],
                ],

                // $requestedDataMapperEntity
                'SomeEntityClass',

                // $expectedException
                null,
            ],
            [
                // $config
                [
                    'entity_data_mapper_map' => [
                        'AnotherEntityClass'    => 'SomeDataMapperServiceName',
                    ],
                ],

                // $requestedDataMapperEntity
                'SomeEntityClass',

                // $expectedException
                InvalidArgumentException::class,
            ],
            [
                // $config
                [
                    'entity_data_mapper_map' => [
                        'SomeEntityClass'       => 'SomeDataMapperServiceName',
                        'AnotherEntityClass'    => 'SomeDataMapperServiceName',
                    ],
                    'factories' => [
                        'SomeDataMapperServiceName' => function () {
                            $mock = $this->getMock(DataMapperInterface::class);
                            $mock->expects($this->any())->method('getEntityClass')->willReturn('AnotherEntityClass');

                            return $mock;
                        },
                    ],
                ],

                // $requestedDataMapperEntity
                'SomeEntityClass',

                // $expectedException
                RuntimeException::class,
            ],
            [
                // $config
                [
                    'entity_data_mapper_map' => [
                        'SomeEntityClass'       => 'SomeDataMapperServiceName',
                        'AnotherEntityClass'    => 'SomeDataMapperServiceName',
                    ],
                    'factories' => [
                        'SomeDataMapperServiceName' => function () {
                            $mock = $this->getMock(DataMapperInterface::class);
                            $mock->expects($this->any())->method('getEntityClass')->willReturn('AnotherEntityClass');

                            return $mock;
                        },
                    ],
                ],

                // $requestedDataMapperEntity
                'AnotherEntityClass',

                // $expectedException
                null,
            ],
        ];
    }
}

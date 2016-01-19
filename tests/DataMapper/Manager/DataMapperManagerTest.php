<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\DataMapper\Manager;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\DataMapper\DataMapperInterface;
use Thorr\Persistence\DataMapper\Manager\DataMapperManager;
use Thorr\Persistence\DataMapper\Manager\DataMapperManagerConfig;
use Thorr\Persistence\Entity\SluggableInterface;
use Thorr\Persistence\Test\Asset;
use Zend\ServiceManager\Config;
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
                [ InvalidArgumentException::class, 'Invalid data mapper'],
            ],
            [
                // $dataMapper
                $this->getMock(DataMapperInterface::class),
                // $expectedException
                [ InvalidArgumentException::class, 'Invalid entity class' ],
            ],
            [
                // $dataMapper
                function () {
                    $mock = $this->getMock(DataMapperInterface::class);
                    $mock->expects($this->any())->method('getEntityClass')->willReturn(Asset\Entity::class);

                    return $mock;
                },
                // $expectedException
                null,
            ],
        ];
    }

    /**
     * @param array  $config
     * @param string $requestedDataMapperEntity
     * @param bool   $expectedException
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

        if (is_string($expectedException)) {
            $this->setExpectedException($expectedException);
        }

        if (is_array($expectedException)) {
            $this->setExpectedException($expectedException[0], $expectedException[1]);
        }

        $dataMapper = $dataMapperManager->getDataMapperForEntity($requestedDataMapperEntity);

        if ($expectedException) {
            return;
        }
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
            'empty config' => [
                // $config
                [],

                // $requestedDataMapperEntity
                'anything',

                // $expectedException
                [ InvalidArgumentException::class, 'Could not find data mapper service name' ],
            ],
            'no data mappers' => [
                // $config
                [
                    'entity_data_mapper_map' => [],
                ],

                // $requestedDataMapperEntity
                'anything',

                // $expectedException
                InvalidArgumentException::class,
            ],
            'valid data mapper config' => [
                // $config
                [
                    'entity_data_mapper_map' => [
                        Asset\Entity::class => 'SomeDataMapperServiceName',
                    ],
                    'factories' => [
                        'SomeDataMapperServiceName' => function () {
                            $mock = $this->getMock(DataMapperInterface::class);
                            $mock->expects($this->any())->method('getEntityClass')->willReturn(Asset\Entity::class);

                            return $mock;
                        },
                    ],
                ],

                // $requestedDataMapperEntity
                Asset\Entity::class,

                // $expectedException
                null,
            ],
            'inexistent service' => [
                // $config
                [
                    'entity_data_mapper_map' => [
                        Asset\AnotherEntity::class    => 'SomeDataMapperServiceName',
                    ],
                ],

                // $requestedDataMapperEntity
                Asset\Entity::class,

                // $expectedException
                [ InvalidArgumentException::class, 'Could not find data mapper service name'],
            ],
            [
                // $config
                [
                    'entity_data_mapper_map' => [
                        Asset\Entity::class           => 'SomeDataMapperServiceName',
                        Asset\AnotherEntity::class    => 'SomeDataMapperServiceName',
                    ],
                    'factories' => [
                        'SomeDataMapperServiceName' => function () {
                            $mock = $this->getMock(DataMapperInterface::class);
                            $mock->expects($this->any())->method('getEntityClass')->willReturn(Asset\AnotherEntity::class);

                            return $mock;
                        },
                    ],
                ],

                // $requestedDataMapperEntity
                Asset\Entity::class,

                // $expectedException
                [ RuntimeException::class, 'entity class mismatch' ],
            ],
            [
                // $config
                [
                    'entity_data_mapper_map' => [
                        Asset\Entity::class           => 'SomeDataMapperServiceName',
                        Asset\AnotherEntity::class    => 'SomeDataMapperServiceName',
                    ],
                    'factories' => [
                        'SomeDataMapperServiceName' => function () {
                            $mock = $this->getMock(DataMapperInterface::class);
                            $mock->expects($this->any())->method('getEntityClass')->willReturn(Asset\AnotherEntity::class);

                            return $mock;
                        },
                    ],
                ],

                // $requestedDataMapperEntity
                Asset\AnotherEntity::class,

                // $expectedException
                null,
            ],
            [
                // $config
                [
                    'entity_data_mapper_map' => [
                        SluggableInterface::class       => 'SomeDataMapperServiceName',
                    ],
                    'factories' => [
                        'SomeDataMapperServiceName' => function () {
                            $mock = $this->getMock(DataMapperInterface::class);
                            $mock->expects($this->any())->method('getEntityClass')->willReturn(Asset\Entity::class);

                            return $mock;
                        },
                    ],
                ],

                // $requestedDataMapperEntity
                SluggableInterface::class,

                // $expectedException
                null,
            ],
        ];
    }

    public function testConstructorNeedsADataMapperManagerConfigIfNotNull()
    {
        $this->setExpectedException(
            InvalidArgumentException::class,
            'expected to be instanceof of "Thorr\Persistence\DataMapper\Manager\DataMapperManagerConfig"'
        );

        new DataMapperManager(new Config());
    }
}

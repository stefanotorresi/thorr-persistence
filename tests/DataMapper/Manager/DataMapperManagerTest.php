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
use Zend\ServiceManager\Exception\InvalidArgumentException;
use Zend\ServiceManager\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorInterface;

class DataMapperManagerTest extends TestCase
{
    public function testValidatePlugin()
    {
        $dataMapperManager = new DataMapperManager();

        $dataMapper        = $this->getMock(DataMapperInterface::class);
        $notADataMapper    = new \stdClass();

        $dataMapperManager->validatePlugin($dataMapper);

        $this->setExpectedException(RuntimeException::class);

        $dataMapperManager->validatePlugin($notADataMapper);
    }

    /**
     * @dataProvider configProvider
     * @param array $config
     * @param bool  $shouldThrowException
     */
    public function testGetDataMapperForEntity($config, $shouldThrowException)
    {
        $dataMapperManager = new DataMapperManager();

        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);
        $serviceLocator->expects($this->any())
                        ->method('get')
                        ->with('config')
                        ->willReturn($config);

        $dataMapper = $this->getMock(DataMapperInterface::class);

        $dataMapperManager->setServiceLocator($serviceLocator);
        $dataMapperManager->setService('SomeDataMapper', $dataMapper);

        if ($shouldThrowException) {
            $this->setExpectedException(InvalidArgumentException::class, 'SomeEntityClass');
            $dataMapperManager->getDataMapperForEntity('SomeEntityClass');
        } else {
            $this->assertSame($dataMapper, $dataMapperManager->getDataMapperForEntity('SomeEntityClass'));
        }
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

                // $shouldTrowException
                true,
            ],
            [
                // $config
                [
                    'thorr_persistence' => []
                ],

                // $shouldTrowException
                true,
            ],
            [
                // $config
                [
                    'thorr_persistence' => [
                        'data_mappers' => [],
                    ]
                ],

                // $shouldTrowException
                true
            ],
            [
                // $config
                [
                    'thorr_persistence' => [
                        'data_mappers' => [
                            'SomeEntityClass' => 'SomeDataMapper',
                        ],
                    ]
                ],

                // $shouldTrowException
                false
            ],
            [
                // $config
                [
                    'thorr_persistence' => [
                        'data_mappers' => [
                            'AnotherEntityClass' => 'SomeDataMapper',
                        ],
                    ]
                ],

                // $shouldTrowException
                true
            ],
        ];
    }
}

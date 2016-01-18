<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Validator;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\DataMapper\EntityFinderInterface;
use Thorr\Persistence\DataMapper\Manager\DataMapperManagerInterface;
use Thorr\Persistence\Validator\AbstractEntityValidator;
use Zend\Validator\Exception;

class AbstractEntityValidatorTest extends TestCase
{
    /**
     * @param array $arguments
     *
     * @dataProvider constructorValidArgumentsProvider
     */
    public function testConstructorWithValidArguments($arguments)
    {
        /** @var AbstractEntityValidator $validator */
        $validator = $this->getMockForAbstractClass(AbstractEntityValidator::class, $arguments);

        foreach ($arguments[0] as $property => $value) {
            $property = str_replace('_', '', $property);
            $method   = 'get' . $property;
            if (! method_exists($validator, $method)) {
                continue;
            }
            $this->assertSame($value, $validator->$method());
        }
    }

    /**
     * @param array  $arguments
     * @param string $expectedExceptionClass
     * @param string $expectedExceptionMessage
     *
     * @dataProvider constructorInvalidArgumentsProvider
     */
    public function testConstructorWithInvalidArguments($arguments, $expectedExceptionClass, $expectedExceptionMessage)
    {
        $this->setExpectedException($expectedExceptionClass, $expectedExceptionMessage);

        /* @var AbstractEntityValidator $validator */
        $this->getMockForAbstractClass(AbstractEntityValidator::class, $arguments);
    }

    public function constructorValidArgumentsProvider()
    {
        $dmm = $this->getMock(DataMapperManagerInterface::class);
        $dmm->expects($this->any())
            ->method('getDataMapperForEntity')
            ->willReturn($this->getMock(EntityFinderInterface::class));

        return [
            [
                [ [ 'finder' => function () { } ] ],
            ],
            [
                [
                    [
                        'finder'      => $this->getMock(\stdClass::class, [ 'findBySomeProperty' ]),
                        'find_method' => 'findBySomeProperty',
                    ],
                ],
            ],
            [
                [
                    [
                        'entity_class' => 'FooBar',
                    ],
                    $dmm,
                ],
            ],
        ];
    }

    public function constructorInvalidArgumentsProvider()
    {
        return [
            [
                [ ],
                Exception\InvalidArgumentException::class,
                'No finder nor entity class provided',
            ],
            [
                [ [ 'finder' => 'foo' ] ],
                Exception\InvalidArgumentException::class,
                'Finder must be an object or a callable',
            ],
            [
                [ [ 'finder' => new \stdClass() ] ],
                Exception\InvalidArgumentException::class,
                "'findByUuid' method not found in 'stdClass'",
            ],
            [
                [
                    [
                        'finder'      => $this->getMock(EntityFinderInterface::class),
                        'find_method' => 'findBySomeThing',
                    ],
                ],
                Exception\InvalidArgumentException::class,
                "'findBySomeThing' method not found",
            ],
        ];
    }

    public function testExcludedSetter()
    {
        $options = [
            'finder'   => function () {},
            'excluded' => 'foo',
        ];

        /** @var AbstractEntityValidator $validator */
        $validator = $this->getMockForAbstractClass(AbstractEntityValidator::class, [$options]);

        $this->assertSame([$options['excluded']], $validator->getExcluded());
    }

    public function testNonArrayFinderResultIsReturnedInArray()
    {
        $finder = function ($val) { return $val; };
        /** @var AbstractEntityValidator $validator */
        $validator = $this->getMockForAbstractClass(AbstractEntityValidator::class, [['finder' => $finder]]);

        $method = new \ReflectionMethod($validator, 'findEntity');
        $method->setAccessible(true);
        $this->assertEquals(['foo'], $method->invoke($validator, 'foo'));
        $this->assertEquals(['foo'], $method->invoke($validator, ['foo']));
        $this->assertEquals([ false ], $method->invoke($validator, false)); // false is indeed a value
        $this->assertEquals([], $method->invoke($validator, null));
        $this->assertEquals([], $method->invoke($validator, []));
    }
}

<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Validator;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\Validator\AbstractEntityValidator;
use Zend\Validator\Exception;

class AbstractEntityValidatorTest extends TestCase
{
    /**
     * @param array $args
     * @param array $expectedException
     * @dataProvider constructorDataProvider
     */
    public function testConstructor($args, $expectedException)
    {
        if ($expectedException) {
            call_user_func_array([ $this, 'setExpectedException'], $expectedException);
        }

        /** @var AbstractEntityValidator $validator */
        $validator = $this->getMockForAbstractClass(AbstractEntityValidator::class, $args);

        if (! $expectedException) {
            foreach ($args[0] as $property => $value) {
                $property = str_replace('_', '', $property);
                $this->assertSame($value, $validator->{'get'.$property}());
            }
        }
    }

    public function constructorDataProvider()
    {
        return [
            [
                [],
                [ Exception\InvalidArgumentException::class, 'No finder provided'],
            ],
            [
                [ ['finder' => 'foo'] ],
                [ Exception\InvalidArgumentException::class, 'Finder must be an object or a callable']
            ],
            [
                [ ['finder' => function () {}] ],
                null
            ],
            [
                [ ['finder' => new \stdClass()] ],
                [ Exception\InvalidArgumentException::class, "'findByUuid' method not found in 'stdClass'"]
            ],
            [
                [ [
                      'finder' => $this->getMock(\stdClass::class, ['findBySomeProperty']),
                      'find_method' => 'findBySomeProperty',
                  ],
                ],
                null
            ]
        ];
    }

    public function testExcludedSetter()
    {
        $options = [
            'finder' => function () {},
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

        $method = new \ReflectionMethod($validator, 'findResult');
        $method->setAccessible(true);
        $this->assertEquals(['foo'], $method->invoke($validator, 'foo'));
        $this->assertEquals(['foo'], $method->invoke($validator, ['foo']));
        $this->assertEquals([ false ], $method->invoke($validator, false)); // false is indeed a value
        $this->assertEquals([], $method->invoke($validator, null));
        $this->assertEquals([], $method->invoke($validator, []));
    }
}

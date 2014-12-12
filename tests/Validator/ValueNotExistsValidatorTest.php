<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Validator;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\Validator\ValueNotExistsValidator;

class ValueNotExistsValidatorTest extends TestCase
{
    public function testIsValid()
    {
        $finder = function () {
            return [];
        };

        $validator = new ValueNotExistsValidator(['finder' => $finder]);

        $this->assertTrue($validator->isValid('foo'));
    }

    public function testIsNotValid()
    {
        $finder = function ($value) {
            return [$value];
        };

        $validator = new ValueNotExistsValidator(['finder' => $finder]);

        $this->assertFalse($validator->isValid('foo'));

        $this->assertArrayHasKey(ValueNotExistsValidator::ERROR_VALUE_EXISTS, $validator->getMessages());
    }
}

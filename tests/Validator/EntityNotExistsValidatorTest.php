<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Validator;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\Validator\EntityNotExistsValidator;

class EntityNotExistsValidatorTest extends TestCase
{
    public function testIsValid()
    {
        $finder = function () {
            return [];
        };

        $validator = new EntityNotExistsValidator([ 'finder' => $finder]);

        $this->assertTrue($validator->isValid('foo'));
    }

    public function testIsNotValid()
    {
        $finder = function ($value) {
            return [$value];
        };

        $validator = new EntityNotExistsValidator([ 'finder' => $finder]);

        $this->assertFalse($validator->isValid('foo'));

        $this->assertArrayHasKey(EntityNotExistsValidator::ERROR_VALUE_EXISTS, $validator->getMessages());
    }
}

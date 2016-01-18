<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Validator;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\Validator\EntityExistsValidator;

class EntityExistsValidatorTest extends TestCase
{
    public function testIsValid()
    {
        $finder = function ($value) {
            return [ $value ];
        };

        $validator = new EntityExistsValidator([ 'finder' => $finder]);

        $this->assertTrue($validator->isValid('foo'));
    }

    public function testIsNotValid()
    {
        $finder = function () {
            return [];
        };

        $validator = new EntityExistsValidator([ 'finder' => $finder]);

        $this->assertFalse($validator->isValid('foo'));

        $this->assertArrayHasKey(EntityExistsValidator::ERROR_ENTITY_NOT_EXISTS, $validator->getMessages());
    }
}

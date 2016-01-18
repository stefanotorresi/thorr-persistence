<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Validator;

class EntityNotExistsValidator extends AbstractEntityValidator
{
    const ERROR_VALUE_EXISTS = 'valueExists';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_VALUE_EXISTS => 'The value already exists',
    ];

    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $result = $this->findEntity($value);

        if (! $result || in_array($result, $this->excluded)) {
            return true;
        }

        $this->error(static::ERROR_VALUE_EXISTS);

        return false;
    }
}

<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Validator;

class EntityExistsValidator extends AbstractEntityValidator
{
    const ERROR_ENTITY_NOT_EXISTS = 'entityNotExists';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_ENTITY_NOT_EXISTS => 'Entity not found',
    ];

    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $result = $this->findEntity($value);

        if ($result && ! in_array($result, $this->excluded)) {
            return true;
        }

        $this->error(static::ERROR_ENTITY_NOT_EXISTS);

        return false;
    }
}

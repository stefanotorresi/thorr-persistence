<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Validator;

class EntityExistsValidator extends AbstractEntityValidator
{
    const ERROR_VALUE_NOT_EXISTS = 'valueNotExists';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_VALUE_NOT_EXISTS => 'Value not found',
    ];

    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $result = $this->findResult($value);

        if ($result && ! in_array($result, $this->excluded)) {
            return true;
        }

        $this->error(static::ERROR_VALUE_NOT_EXISTS);

        return false;
    }
}

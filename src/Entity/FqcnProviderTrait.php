<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

/**
 * Polyfill for PHP 5.5 ::class
 */
trait FqcnProviderTrait
{
    /**
     * @return string
     */
    public static function fqcn()
    {
        return get_called_class();
    }
}

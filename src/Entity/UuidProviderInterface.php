<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

interface UuidProviderInterface
{
    /**
     * @return string
     */
    public function getUuid();
}

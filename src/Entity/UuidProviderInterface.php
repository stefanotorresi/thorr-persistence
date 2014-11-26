<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

use Rhumsaa\Uuid\Uuid;

interface UuidProviderInterface
{
    /**
     * @return Uuid
     */
    public function getUuid();

    /**
     * @param Uuid $uuid
     */
    public function setUuid(Uuid $uuid);
}

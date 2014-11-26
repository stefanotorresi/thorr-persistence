<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper;

use Rhumsaa\Uuid\Uuid;

interface EntityRemoverInterface
{
    /**
     * @param object $entity
     */
    public function remove($entity);

    /**
     * @param Uuid|string $uuid
     */
    public function removeByUuid($uuid);
}

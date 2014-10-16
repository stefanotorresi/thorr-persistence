<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper;

/**
 * BEHOLD! I'm the entity saver!
 */
interface EntitySaverInterface
{
    /**
     * @param  object $entity
     * @return bool             returns true on success
     */
    public function save($entity);
}

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
interface EntitySaverInterface extends DataMapperInterface
{
    /**
     * @param object $entity
     */
    public function save($entity);
}

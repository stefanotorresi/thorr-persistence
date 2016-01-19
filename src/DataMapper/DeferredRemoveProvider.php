<?php
/**
 * @license See the file LICENSE for copying permission
 */

namespace Thorr\Persistence\DataMapper;

interface DeferredRemoveProvider extends DeferredOperationProvider
{
    /**
     * Removes from memory. Actually persist the removal via subsequent commit()
     *
     * @param object $entity
     */
    public function removeDeferred($entity);
}

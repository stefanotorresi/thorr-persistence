<?php
/**
 * @license See the file LICENSE for copying permission
 */

namespace Thorr\Persistence\DataMapper;

interface DeferredSaveProvider extends DeferredOperationProvider
{
    /**
     * Saves in memory. Actually persist the changes via subsequent commit()
     *
     * @param object $entity
     */
    public function saveDeferred($entity);
}

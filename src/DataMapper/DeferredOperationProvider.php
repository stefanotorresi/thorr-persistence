<?php
/**
 * @license See the file LICENSE for copying permission
 */

namespace Thorr\Persistence\DataMapper;

interface DeferredOperationProvider
{
    /**
     * Commits any in-memory change previously registered with deferred methods
     *
     * @return void
     */
    public function commit();
}

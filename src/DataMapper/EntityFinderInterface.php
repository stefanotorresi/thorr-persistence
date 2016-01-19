<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper;

use Ramsey\Uuid\Uuid;

interface EntityFinderInterface extends DataMapperInterface
{
    /**
     * @param Uuid|string $uuid
     *
     * @return object|null
     */
    public function findByUuid($uuid);
}

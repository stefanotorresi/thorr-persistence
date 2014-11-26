<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

use Rhumsaa\Uuid\Uuid;

abstract class AbstractEntity implements UuidProviderInterface
{
    use UuidProviderTrait;

    /**
     * @param Uuid $uuid
     */
    public function __construct(Uuid $uuid = null)
    {
        $this->uuid = $uuid ?: Uuid::uuid4();
    }
}

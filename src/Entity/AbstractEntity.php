<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

use Ramsey\Uuid\Uuid;

abstract class AbstractEntity implements UuidProviderInterface
{
    use UuidProviderTrait;

    /**
     * @param Uuid|string $uuid
     */
    public function __construct($uuid = null)
    {
        if ($uuid !== null && ! $uuid instanceof Uuid) {
            $uuid = Uuid::fromString($uuid);
        }

        if ($uuid === null) {
            $uuid = Uuid::uuid4();
        }

        $this->uuid = $uuid->toString();
    }
}

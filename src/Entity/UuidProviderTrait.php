<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

use Rhumsaa\Uuid\Uuid;

trait UuidProviderTrait
{
    /**
     * @var Uuid
     */
    protected $uuid;

    /**
     * @return Uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}

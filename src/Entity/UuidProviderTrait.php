<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

trait UuidProviderTrait
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}

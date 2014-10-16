<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper;

interface EntityFinderInterface
{
    /**
     * @param  $id
     * @return object|null
     */
    public function find($id);
}

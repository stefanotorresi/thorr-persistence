<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper;

interface EntityRemoverInterface
{
    /**
     * @param object $entity
     */
    public function remove($entity);

    /**
     * @param mixed $id
     */
    public function removeById($id);
}

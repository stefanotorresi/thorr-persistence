<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Repository;

interface RepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param  mixed $entity
     * @return mixed
     */
    public function save($entity);

    /**
     * @param mixed $entity
     */
    public function remove($entity);
}

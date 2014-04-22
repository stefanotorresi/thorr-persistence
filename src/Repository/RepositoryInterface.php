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
     * @param  bool  $flush
     * @return mixed
     */
    public function save($entity, $flush = true);

    /**
     * @param mixed $entity
     * @param bool  $flush
     */
    public function remove($entity, $flush = true);

    /**
     * @param mixed $entity
     */
    public function flush($entity = null);
}

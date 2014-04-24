<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Doctrine\Repository;

use Thorr\Persistence\Repository\RepositoryInterface;

interface ORMRepositoryInterface extends RepositoryInterface
{
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

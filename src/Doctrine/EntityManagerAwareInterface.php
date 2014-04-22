<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;

interface EntityManagerAwareInterface
{
    /**
     * Set the entity manager
     *
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager);

    /**
     * Get the entity manager
     *
     * @return EntityManager
     */
    public function getEntityManager();
}

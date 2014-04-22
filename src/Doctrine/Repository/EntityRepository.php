<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Doctrine\Repository;

use Doctrine\ORM as Doctrine;
use Thorr\Persistence\Repository\RepositoryInterface;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Base for custom Doctrine Entity Repositories
 * implements a generic data mapper contract for compatibility layers
 *
 * Class EntityMapper
 * @package Thorr\Persistence\Doctrine
 */
class EntityRepository extends Doctrine\EntityRepository implements
    RepositoryInterface,
    EventManagerAwareInterface,
    EntityManagerAwareInterface
{
    use EntityRepositoryTrait;

    /**
     * @return Doctrine\EntityManager
     */
    public function getEntityManager()
    {
        return parent::getEntityManager();
    }
}

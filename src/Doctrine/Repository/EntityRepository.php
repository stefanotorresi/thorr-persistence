<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Doctrine\Repository;

use Doctrine\ORM;
use Thorr\Persistence\Doctrine\EntityManagerAwareInterface;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Base for custom Doctrine Entity Repositories
 * implements a generic data mapper contract for compatibility layers
 *
 * Class EntityMapper
 * @package Thorr\Persistence\Doctrine
 */
class EntityRepository extends ORM\EntityRepository implements
    ORMRepositoryInterface,
    EventManagerAwareInterface,
    EntityManagerAwareInterface
{
    use EntityRepositoryTrait;

    /**
     * @return ORM\EntityManager
     */
    public function getEntityManager()
    {
        return parent::getEntityManager();
    }
}

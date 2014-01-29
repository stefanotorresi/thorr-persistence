<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace MyBase\Doctrine;

use Doctrine\ORM as Doctrine;
use MyBase\DataMapper\MapperInterface;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Base for custom Doctrine Entity Repositories
 * implements a generic data mapper contract for compatibility layers
 *
 * Class EntityMapper
 * @package MyBase\Doctrine
 */
class EntityMapper extends Doctrine\EntityRepository implements
    MapperInterface,
    EventManagerAwareInterface,
    EntityManagerAwareInterface
{
    use EntityMapperTrait;

    /**
     * @return Doctrine\EntityManager
     */
    public function getEntityManager()
    {
        return parent::getEntityManager();
    }
}

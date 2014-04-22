<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Doctrine\Repository;

use Thorr\Persistence\Repository\RepositoryEvent as Event;
use Doctrine\ORM as Doctrine;
use Zend\EventManager\EventManagerAwareTrait;

/**
 * This is intended to be used on Doctrine\EntityRepository subclasses
 *
 * Class EntityMapperTrait
 * @package Thorr\Persistence\Doctrine
 * @property Doctrine\EntityManager $_em
 */
trait EntityRepositoryTrait
{
    use EventManagerAwareTrait;

    /**
     * @param  mixed $entity
     * @param  bool  $flush
     * @return mixed
     */
    public function save($entity, $flush = true)
    {
        $this->getEventManager()->trigger(new Event(Event::SAVE_PRE, $this, [], $entity));

        $this->getEntityManager()->persist($entity);

        $flush && $this->flush();

        $this->getEventManager()->trigger(new Event(Event::SAVE_POST, $this, [], $entity));

        return $entity;
    }

    /**
     * @param mixed $entity
     * @param bool  $flush
     */
    public function remove($entity, $flush = true)
    {
        $this->getEventManager()->trigger(new Event(Event::REMOVE_PRE, $this, [], $entity));

        $this->getEntityManager()->remove($entity);

        $flush && $this->flush();

        $this->getEventManager()->trigger(new Event(Event::REMOVE_POST, $this, [], $entity));
    }

    /**
     * @param mixed $entity
     */
    public function flush($entity = null)
    {
        $this->getEventManager()->trigger(new Event(Event::FLUSH_PRE, $this, [], $entity));

        $this->getEntityManager()->flush($entity);

        $this->getEventManager()->trigger(new Event(Event::FLUSH_POST, $this, [], $entity));
    }

    /**
     * Set the entity manager
     *
     * @param  Doctrine\EntityManager $entityManager
     * @return $this
     */
    public function setEntityManager(Doctrine\EntityManager $entityManager)
    {
        $this->_em = $entityManager;

        return $this;
    }
}

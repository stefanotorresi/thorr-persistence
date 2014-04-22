<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace MyBase\Doctrine;

use MyBase\DataMapper\MapperEvent as Event;
use Doctrine\ORM as Doctrine;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Paginator\Paginator;

/**
 * This is intended to be used on Doctrine\EntityRepository subclasses
 *
 * Class EntityMapperTrait
 * @package MyBase\Doctrine
 * @property Doctrine\EntityManager $_em
 */
trait EntityMapperTrait
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

    /**
     * @param  Doctrine\Query|Doctrine\QueryBuilder $query
     * @param  int                                  $page
     * @param  int                                  $itemCountPerPage
     * @param  bool                                 $fetchJoinCollection
     * @return Paginator
     */
    protected function getPaginatorFromQuery($query, $page, $itemCountPerPage = 20, $fetchJoinCollection = true)
    {
        $paginator = new Paginator(new DoctrinePaginatorAdapter(new DoctrinePaginator($query, $fetchJoinCollection)));
        $paginator->setDefaultItemCountPerPage($itemCountPerPage);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }
}

<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace MyBase\Doctrine;

use MyBase\DataMapper\MapperInterface;
use MyBase\DataMapper\MapperEvent as Event;
use Doctrine\ORM as Doctrine;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Paginator\Paginator;

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
     * @return Doctrine\EntityManager
     */
    public function getEntityManager()
    {
        return parent::getEntityManager();
    }

    /**
     * @param  Doctrine\Query|Doctrine\QueryBuilder $query
     * @param  int                                  $page
     * @param  int                                  $itemCountPerPage
     * @return Paginator
     */
    protected function getPaginatorFromQuery($query, $page, $itemCountPerPage = 20)
    {
        $paginator = new Paginator(new DoctrinePaginatorAdapter(new DoctrinePaginator($query)));
        $paginator->setDefaultItemCountPerPage($itemCountPerPage);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }
}

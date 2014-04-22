<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Doctrine;

use Thorr\Persistence\Repository\RepositoryEvent;
use Thorr\Persistence\Doctrine\Repository\EntityRepository;
use PHPUnit_Framework_TestCase;

class EntityRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EntityRepository
     */
    protected $entityRepository;

    public function setUp()
    {
        $entityManager = $this->getMock('\Doctrine\ORM\EntityManager', [], [], '', false);
        $classMetadata = $this->getMock('\Doctrine\ORM\Mapping\ClassMetadata', [], [], '', false);

        $this->entityRepository = new EntityRepository($entityManager, $classMetadata);
    }

    public function testFlush()
    {
        $entity = new \stdClass();

        $flushPreTriggered = false;
        $flushPostTriggered = false;

        $this->entityRepository->getEventManager()->attach(
            RepositoryEvent::FLUSH_PRE,
            function (RepositoryEvent $event) use (&$flushPreTriggered) {
                $flushPreTriggered = true;
            }
        );

        $this->entityRepository->getEventManager()->attach(
            RepositoryEvent::FLUSH_POST,
            function (RepositoryEvent $event) use (&$flushPostTriggered) {
                $flushPostTriggered = true;
            }
        );

        $this->entityRepository->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('flush')
            ->with($entity);

        $this->entityRepository->flush($entity);

        $this->assertTrue($flushPreTriggered);
        $this->assertTrue($flushPostTriggered);
    }

    public function testSave()
    {
        $entity = new \stdClass();

        $savePreTriggered = false;
        $savePostTriggered = false;

        $this->entityRepository->getEventManager()->attach(
            RepositoryEvent::SAVE_PRE,
            function (RepositoryEvent $event) use (&$savePreTriggered) {
                $savePreTriggered = true;
            }
        );

        $this->entityRepository->getEventManager()->attach(
            RepositoryEvent::SAVE_POST,
            function (RepositoryEvent $event) use (&$savePostTriggered) {
                $savePostTriggered = true;
            }
        );

        $this->entityRepository->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('persist')
            ->with($entity);

        $this->entityRepository->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('flush');

        $result = $this->entityRepository->save($entity);

        $this->assertTrue($savePreTriggered);
        $this->assertTrue($savePostTriggered);
        $this->assertSame($entity, $result);
    }

    public function testSaveWithoutFlushing()
    {
        $this->entityRepository->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('persist');

        $this->entityRepository->getEntityManager()
            ->expects($this->never())
            ->method('flush');

        $this->entityRepository->save(null, false);
    }

    public function testRemove()
    {
        $entity = new \stdClass();

        $removePreTriggered = false;
        $removePostTriggered = false;

        $this->entityRepository->getEventManager()->attach(
            RepositoryEvent::REMOVE_PRE,
            function (RepositoryEvent $event) use (&$removePreTriggered) {
                $removePreTriggered = true;
            }
        );

        $this->entityRepository->getEventManager()->attach(
            RepositoryEvent::REMOVE_POST,
            function (RepositoryEvent $event) use (&$removePostTriggered) {
                $removePostTriggered = true;
            }
        );

        $this->entityRepository->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('remove')
            ->with($entity);

        $this->entityRepository->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('flush');

        $this->entityRepository->remove($entity);

        $this->assertTrue($removePreTriggered);
        $this->assertTrue($removePostTriggered);
    }

    public function testRemoveWithoutFlushing()
    {
        $this->entityRepository->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('remove');

        $this->entityRepository->getEntityManager()
            ->expects($this->never())
            ->method('flush');

        $this->entityRepository->remove(null, false);
    }

    public function testEntityManagerSetterProvidesFluentInterface()
    {
        $this->assertSame(
            $this->entityRepository,
            $this->entityRepository->setEntityManager($this->entityRepository->getEntityManager())
        );
    }
}

<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace MyBase\Test\Doctrine;

use Doctrine\ORM\EntityManager;
use MyBase\DataMapper\MapperEvent;
use MyBase\Doctrine\EntityMapper;
use PHPUnit_Framework_TestCase;

class EntityMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EntityMapper
     */
    protected $entityMapper;

    public function setUp()
    {
        $entityManager = $this->getMock('\Doctrine\ORM\EntityManager', [], [], '', false);
//        $entityManager->expects($this->any())
//            ->method('getUnitOfWork')
//            ->will($this->returnValue($unitOfWork));

        $classMetadata = $this->getMock('\Doctrine\ORM\Mapping\ClassMetadata', [], [], '', false);

        $entityMapper = new EntityMapper($entityManager, $classMetadata);

        $this->entityMapper = $entityMapper;
    }

    public function testFlush()
    {
        $entity = new \stdClass();

        $flushPreTriggered = false;
        $flushPostTriggered = false;

        $this->entityMapper->getEventManager()->attach(
            MapperEvent::FLUSH_PRE,
            function (MapperEvent $event) use (&$flushPreTriggered) {
                $flushPreTriggered = true;
            }
        );

        $this->entityMapper->getEventManager()->attach(
            MapperEvent::FLUSH_POST,
            function (MapperEvent $event) use (&$flushPostTriggered) {
                $flushPostTriggered = true;
            }
        );

        $this->entityMapper->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('flush')
            ->with($entity);

        $this->entityMapper->flush($entity);

        $this->assertTrue($flushPreTriggered);
        $this->assertTrue($flushPostTriggered);
    }

    public function testSave()
    {
        $entity = new \stdClass();

        $savePreTriggered = false;
        $savePostTriggered = false;

        $this->entityMapper->getEventManager()->attach(
            MapperEvent::SAVE_PRE,
            function (MapperEvent $event) use (&$savePreTriggered) {
                $savePreTriggered = true;
            }
        );

        $this->entityMapper->getEventManager()->attach(
            MapperEvent::SAVE_POST,
            function (MapperEvent $event) use (&$savePostTriggered) {
                $savePostTriggered = true;
            }
        );

        $this->entityMapper->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('persist')
            ->with($entity);

        $this->entityMapper->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('flush');

        $result = $this->entityMapper->save($entity);

        $this->assertTrue($savePreTriggered);
        $this->assertTrue($savePostTriggered);
        $this->assertSame($entity, $result);
    }

    public function testSaveWithoutFlushing()
    {
        $this->entityMapper->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('persist');

        $this->entityMapper->getEntityManager()
            ->expects($this->never())
            ->method('flush');

        $this->entityMapper->save(null, false);
    }

    public function testRemove()
    {
        $entity = new \stdClass();

        $removePreTriggered = false;
        $removePostTriggered = false;

        $this->entityMapper->getEventManager()->attach(
            MapperEvent::REMOVE_PRE,
            function (MapperEvent $event) use (&$removePreTriggered) {
                $removePreTriggered = true;
            }
        );

        $this->entityMapper->getEventManager()->attach(
            MapperEvent::REMOVE_POST,
            function (MapperEvent $event) use (&$removePostTriggered) {
                $removePostTriggered = true;
            }
        );

        $this->entityMapper->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('remove')
            ->with($entity);

        $this->entityMapper->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('flush');

        $this->entityMapper->remove($entity);

        $this->assertTrue($removePreTriggered);
        $this->assertTrue($removePostTriggered);
    }

    public function testRemoveWithoutFlushing()
    {
        $this->entityMapper->getEntityManager()
            ->expects($this->atLeastOnce())
            ->method('remove');

        $this->entityMapper->getEntityManager()
            ->expects($this->never())
            ->method('flush');

        $this->entityMapper->remove(null, false);
    }

    public function testEntityManagerSetterProvidesFluentInterface()
    {
        $this->assertSame(
            $this->entityMapper,
            $this->entityMapper->setEntityManager($this->entityMapper->getEntityManager())
        );
    }
}

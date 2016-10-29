<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Entity;

use Doctrine\Instantiator\Instantiator;
use PHPUnit_Framework_TestCase as TestCase;
use Ramsey\Uuid\Uuid;
use Thorr\Persistence\Entity\AbstractEntity;
use Thorr\Persistence\Test\Asset\TestEntity;

class AbstractEntityTest extends TestCase
{
    public function testUuid()
    {
        $uuid = Uuid::uuid4();

        /** @var AbstractEntity $entity */
        $entity = $this->getMockForAbstractClass(AbstractEntity::class, [ $uuid ]);

        $this->assertEquals($uuid, $entity->getUuid());
    }

    public function testUuidIsAutomaticallyGenerated()
    {
        /** @var AbstractEntity $entity */
        $entity = $this->getMockForAbstractClass(AbstractEntity::class);

        $this->assertNotEmpty($entity->getUuid());
        $this->assertTrue(Uuid::isValid($entity->getUuid()));
    }

    public function testUuidFromString()
    {
        $uuid = Uuid::uuid4()->toString();

        /** @var AbstractEntity $entity */
        $entity = $this->getMockForAbstractClass(AbstractEntity::class, [ $uuid ]);

        $this->assertSame($uuid, $entity->getUuid());
    }

    public function testCloningChangesUuid()
    {
        $entity = new TestEntity();

        $clone = clone $entity;
        $this->assertNotEquals($entity->getUuid(), $clone->getUuid());
    }

    public function testCloningDoesntRefreshUuidIfWasntSet()
    {
        $instantiator = new Instantiator();
        /** @var TestEntity $entity */
        $entity = $instantiator->instantiate(TestEntity::class);
        $this->assertNull($entity->getUuid());
        $clone = clone $entity;
        $this->assertNull($clone->getUuid());
    }
}

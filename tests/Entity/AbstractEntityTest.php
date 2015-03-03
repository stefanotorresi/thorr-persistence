<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Entity;

use PHPUnit_Framework_TestCase as TestCase;
use Rhumsaa\Uuid\Uuid;
use Thorr\Persistence\Entity\AbstractEntity;

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
}

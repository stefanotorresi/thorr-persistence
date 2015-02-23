<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Entity;

use PHPUnit_Framework_TestCase as TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Thorr\Persistence\Entity\SluggableTrait;

class SluggableTraitTest extends TestCase
{
    public function testSetterDoesntCastNullToEmptyString()
    {
        /** @var SluggableTrait|MockObject $sluggable */
        $sluggable = $this->getMockForTrait(SluggableTrait::class);

        $this->assertNull($sluggable->getSlug());

        $sluggable->setSlug(false);
        $this->assertSame('', $sluggable->getSlug());

        $sluggable->setSlug(null);
        $this->assertNull($sluggable->getSlug());
    }
}

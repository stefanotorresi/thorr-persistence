<?php
/**
 * @license See the file LICENSE for copying permission
 */

namespace Thorr\Persistence\Test\DataMapper\Manager;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\DataMapper\Manager\DataMapperManager;
use Thorr\Persistence\DataMapper\Manager\DataMapperManagerAwareTrait;

class DataMapperManagerAwareTraitTest extends TestCase
{
    public function testAccessors()
    {
        $sut = $this->getMockForTrait(DataMapperManagerAwareTrait::class);
        $dmm = new DataMapperManager();

        $sut->setDataMapperManager($dmm);

        $this->assertSame($dmm, $sut->getDataMapperManager());
    }
}

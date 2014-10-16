<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\DataMapper\Manager;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence\DataMapper\AbstractDataMapper;
use Thorr\Persistence\DataMapper\Manager\DataMapperManager;
use Zend\ServiceManager\Exception\RuntimeException;

class DataMapperManagerTest extends TestCase
{
    public function testValidatePlugin()
    {
        $dataMapperManager = new DataMapperManager();
        $dataMapper        = $this->getMock(AbstractDataMapper::class);
        $notADataMapper    = new \stdClass();

        $this->assertNull($dataMapperManager->validatePlugin($dataMapper));

        $this->setExpectedException(RuntimeException::class);

        $dataMapperManager->validatePlugin($notADataMapper);
    }
}

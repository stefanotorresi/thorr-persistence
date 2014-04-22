<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace MyBase\Test\Doctrine;

use Doctrine\ORM\EntityManager;
use MyBase\Doctrine\EntityManagerAwareInitializer;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class EntityManagerAwareInitializerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function setUp()
    {
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $entityManager = $this->getMock('Doctrine\ORM\EntityManager', [], [], '', false);

        $serviceLocator->expects($this->any())
            ->method('get')
            ->with('Doctrine\ORM\EntityManager')
            ->will($this->returnValue($entityManager));

        $this->serviceLocator = $serviceLocator;
        $this->entityManager = $entityManager;
    }

    public function testInitialize()
    {
        $initializer = new EntityManagerAwareInitializer();

        $instance = $this->getMock('\MyBase\Doctrine\EntityManagerAwareInterface');
        $instance->expects($this->atLeastOnce())
                 ->method('setEntityManager')
                 ->with($this->entityManager);

        $initializer->initialize($instance, $this->serviceLocator);
    }

    public function testInterfaceCheck()
    {
        $instance = $this->getMock('stdCass');
        $instance->expects($this->never())
            ->method('setEntityManager');

        $initializer = new EntityManagerAwareInitializer();
        $initializer->initialize($instance, $this->serviceLocator);
    }
}

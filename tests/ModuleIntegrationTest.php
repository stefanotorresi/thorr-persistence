<?php
/**
 * @license See the file LICENSE for copying permission.
 */

namespace Thorr\Persistence\Test;

use PHPUnit_Framework_TestCase as TestCase;
use Thorr\Persistence;
use Thorr\Persistence\DataMapper;
use Zend\InputFilter\InputFilter;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;

class ModuleIntegrationTest extends TestCase
{
    /**
     * @var array
     */
    protected $appConfig;

    protected function setUp()
    {
        $this->serviceManager = new ServiceManager();
        $this->appConfig      = [
            'modules' => [
                'Thorr\Persistence',
            ],
            'module_listener_options' => [],
        ];
    }

    public function testCanLoadModule()
    {
        $app           = Application::init($this->appConfig);
        $loadedModules = $app->getServiceManager()->get('ModuleManager')->getLoadedModules();
        $this->assertArrayHasKey('Thorr\Persistence', $loadedModules);
        $this->assertInstanceOf(Persistence\Module::class, $loadedModules['Thorr\Persistence']);
    }

    public function testServicesAreRegistered()
    {
        $app            = Application::init($this->appConfig);
        $serviceManager = $app->getServiceManager();

        $this->assertTrue($serviceManager->has('DataMapperManager'));
        $this->assertTrue($serviceManager->has(DataMapper\Manager\DataMapperManager::class));

        $dataMapperManager = $serviceManager->get(DataMapper\Manager\DataMapperManager::class);
        $this->assertInstanceOf(DataMapper\Manager\DataMapperManager::class, $dataMapperManager);
    }

    public function testValidatorsAreRegistered()
    {
        $app              = Application::init($this->appConfig);
        $validatorManager = $app->getServiceManager()->get('ValidatorManager');

        $this->assertTrue($validatorManager->has(Persistence\Validator\EntityExistsValidator::class));
        $this->assertTrue($validatorManager->has(Persistence\Validator\EntityNotExistsValidator::class));
    }

    public function testValidatorConfigCanBeInitializedByZendInputFilterFactory()
    {
        $fooMapper = $this->getMock(DataMapper\DataMapperInterface::class);
        $fooMapper->expects($this->any())->method('getEntityClass')->willReturn(Asset\Entity::class);
        $dmm = new DataMapper\Manager\DataMapperManager(
            new  DataMapper\Manager\DataMapperManagerConfig(
                [
                    'entity_data_mapper_map' => [
                        Asset\Entity::class => 'FooMapper',
                    ],
                    'services' => [
                        'FooMapper' => $fooMapper,
                    ],
                ]
            )
        );

        $app = Application::init($this->appConfig);
        $sm  = $app->getServiceManager();
        $sm->setAllowOverride(true);
        $sm->setService(DataMapper\Manager\DataMapperManager::class, $dmm);

        $inputFilter = new InputFilter();
        $app->getServiceManager()->get('InputFilterManager')->populateFactory($inputFilter);

        $inputFilter->add([
            'name'       => 'test',
            'validators' => [
                [
                    'name'    => Persistence\Validator\EntityExistsValidator::class,
                    'options' => [
                        'entity_class' => Asset\Entity::class,
                    ],
                ],
                [
                    'name'    => Persistence\Validator\EntityNotExistsValidator::class,
                    'options' => [
                        'entity_class' => Asset\Entity::class,
                    ],
                ],
            ],
        ]);

        $this->assertInstanceOf(
            Persistence\Validator\EntityExistsValidator::class,
            $inputFilter->get('test')->getValidatorChain()->getValidators()[0]['instance']
        );

        $this->assertInstanceOf(
            Persistence\Validator\EntityNotExistsValidator::class,
            $inputFilter->get('test')->getValidatorChain()->getValidators()[1]['instance']
        );
    }
}

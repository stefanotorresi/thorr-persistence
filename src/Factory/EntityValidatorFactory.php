<?php
/**
 * @license See the file LICENSE for copying permission
 */

namespace Thorr\Persistence\Factory;

use Thorr\Persistence\DataMapper\Manager\DataMapperManager;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\Validator\ValidatorPluginManager;

class EntityValidatorFactory implements MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    private $validatorClass;

    /**
     * @param $validatorClass
     */
    public function __construct($validatorClass)
    {
        $this->validatorClass = (string) $validatorClass;
    }

    public function __invoke(ValidatorPluginManager $validatorPluginManager)
    {
        $dmm = $validatorPluginManager->getServiceLocator()->get(DataMapperManager::class);

        $class = $this->validatorClass;

        return new $class($this->getCreationOptions(), $dmm);
    }
}

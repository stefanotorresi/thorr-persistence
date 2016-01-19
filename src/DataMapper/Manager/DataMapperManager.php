<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper\Manager;

use Assert\Assertion;
use Thorr\Persistence\DataMapper\DataMapperInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\Exception;

/**
 * @method DataMapperInterface get($name)
 */
class DataMapperManager extends AbstractPluginManager implements DataMapperManagerInterface
{
    /**
     * @var array
     */
    protected $entityDataMapperMap;

    /**
     * {@inheritdoc}
     */
    public function __construct(ConfigInterface $configuration = null)
    {
        parent::__construct($configuration);

        if (! $configuration) {
            return;
        }

        Assertion::isInstanceOf($configuration, DataMapperManagerConfig::class);
        /* @var $configuration DataMapperManagerConfig */

        $this->entityDataMapperMap = $configuration->getEntityDataMapperMap();
    }

    /**
     * {@inheritdoc}
     */
    public function validatePlugin($dataMapper)
    {
        Assertion::isInstanceOf($dataMapper, DataMapperInterface::class, 'Invalid data mapper');
        Assertion::classExists($dataMapper->getEntityClass(), 'Invalid entity class');
    }

    /**
     * @param string $entityClass
     *
     * @return DataMapperInterface
     */
    public function getDataMapperForEntity($entityClass)
    {
        Assertion::keyIsset($this->entityDataMapperMap, $entityClass, sprintf(
            "Could not find data mapper service name for entity class '%s'",
            $entityClass
        ));

        $entityDMServiceName = $this->entityDataMapperMap[$entityClass];

        $dataMapper = $this->get($entityDMServiceName);

        if (! is_a($dataMapper->getEntityClass(), $entityClass, true)) {
            throw new Exception\RuntimeException(sprintf(
                '"%s" entity class mismatch: expected "%s", got "%s"',
                $entityDMServiceName,
                $entityClass,
                $dataMapper->getEntityClass()
            ));
        }

        return $dataMapper;
    }
}

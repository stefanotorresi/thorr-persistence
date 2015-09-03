<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper\Manager;

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

        if ($configuration instanceof DataMapperManagerConfig) {
            $this->entityDataMapperMap = $configuration->getEntityDataMapperMap();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validatePlugin($dataMapper)
    {
        if (! $dataMapper instanceof DataMapperInterface) {
            throw new Exception\RuntimeException(sprintf(
                'Invalid DataMapper type; expected %s, got %s',
                DataMapperInterface::class,
                (is_object($dataMapper) ? get_class($dataMapper) : gettype($dataMapper))
            ));
        }

        if (! class_exists($dataMapper->getEntityClass())) {
            throw new Exception\RuntimeException(sprintf(
                '%s::getEntityClass() must return a valid class', get_class($dataMapper)
            ));
        }
    }

    /**
     * @param string $entityClass
     *
     * @return DataMapperInterface
     */
    public function getDataMapperForEntity($entityClass)
    {
        if (! isset($this->entityDataMapperMap[$entityClass])) {
            throw new Exception\InvalidArgumentException(sprintf(
                "Could not find data mapper service name for entity class '%s'",
                $entityClass
            ));
        }

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

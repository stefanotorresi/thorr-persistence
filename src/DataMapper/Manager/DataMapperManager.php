<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper\Manager;

use Thorr\Persistence\DataMapper\DataMapperInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

/**
 * @method DataMapperInterface get($name)
 */
class DataMapperManager extends AbstractPluginManager
{
    /**
     * Validate the plugin
     *
     * @param  mixed                      $plugin
     * @return void
     * @throws Exception\RuntimeException if invalid
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof DataMapperInterface) {
            // we're okay
            return;
        }

        throw new Exception\RuntimeException(sprintf(
            'Plugin of type %s is invalid; must implement %s',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            DataMapperInterface::class
        ));
    }

    /**
     * @param  string              $entityClass
     * @return DataMapperInterface
     */
    public function getDataMapperForEntity($entityClass)
    {
        $config = $this->getServiceLocator()->get('config');

        if (! isset($config['thorr_persistence']['data_mappers'][$entityClass])) {
            throw new Exception\InvalidArgumentException(sprintf(
                "Could not find data mapper service name for entity class '%s'", $entityClass
            ));
        }

        $dataMapperServiceName = $config['thorr_persistence']['data_mappers'][$entityClass];

        return $this->get($dataMapperServiceName);
    }
}

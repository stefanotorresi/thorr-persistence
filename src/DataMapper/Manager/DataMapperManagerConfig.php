<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper\Manager;

use Zend\ServiceManager\Config;

class DataMapperManagerConfig extends Config
{
    public function getEntityDataMapperMap()
    {
        return (isset($this->config['entity_data_mapper_map'])) ? $this->config['entity_data_mapper_map'] : null;
    }
}

<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper\Manager;

interface DataMapperManagerConfigProviderInterface
{
    /**
     * DataMapperManager configuration
     *
     * @return array|DataMapperManagerConfig
     */
    public function getDataMapperManagerConfig();
}

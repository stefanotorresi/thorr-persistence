<?php
/**
 * @author  Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper\Manager;

use Thorr\Persistence\DataMapper\DataMapperInterface;

/**
 * @method DataMapperInterface get($name)
 */
interface DataMapperManagerInterface
{
    /**
     * @param string $entityClass
     *
     * @return DataMapperInterface
     */
    public function getDataMapperForEntity($entityClass);
}

<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper;

use Traversable;

interface ListFinderInterface extends DataMapperInterface
{
    /**
     * @param array $params
     *
     * @return array|Traversable
     */
    public function findAll($params);
}

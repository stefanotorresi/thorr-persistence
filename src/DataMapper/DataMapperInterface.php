<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper;

interface DataMapperInterface
{
    /**
     * The entity class handled the adapter instance
     *
     * @return string
     */
    public function getEntityClass();
}

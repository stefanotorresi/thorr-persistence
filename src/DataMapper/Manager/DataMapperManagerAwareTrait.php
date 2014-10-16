<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper\Manager;

trait DataMapperManagerAwareTrait
{
    /**
     * @var DataMapperManager
     */
    protected $dataMapperManager;

    /**
     * @return DataMapperManager
     */
    public function getDataMapperManager()
    {
        return $this->dataMapperManager;
    }

    /**
     * @param DataMapperManager $dataMapperManager
     */
    public function setDataMapperManager(DataMapperManager $dataMapperManager)
    {
        $this->dataMapperManager = $dataMapperManager;
    }
}

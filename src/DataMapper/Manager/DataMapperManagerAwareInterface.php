<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper\Manager;

interface DataMapperManagerAwareInterface
{
    public function getDataMapperManager();
    public function setDataMapperManager(DataMapperManager $dataMapperManager);
}

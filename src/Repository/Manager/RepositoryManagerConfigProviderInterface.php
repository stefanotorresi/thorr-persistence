<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Repository\Manager;

interface RepositoryManagerConfigProviderInterface
{
    /**
     * RepositoryManager configuration
     *
     * @return array
     */
    public function getRepositoryManagerConfig();
}

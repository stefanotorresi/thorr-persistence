<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Repository\Manager;

trait RepositoryManagerAwareTrait
{
    /**
     * @var RepositoryManager
     */
    protected $repositoryManager;

    /**
     * @return RepositoryManager
     */
    public function getRepositoryManager()
    {
        return $this->repositoryManager;
    }

    /**
     * @param RepositoryManager $repositoryManager
     */
    public function setRepositoryManager(RepositoryManager $repositoryManager)
    {
        $this->repositoryManager = $repositoryManager;
    }
}

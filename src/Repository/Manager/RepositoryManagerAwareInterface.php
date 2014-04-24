<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Repository\Manager;

interface RepositoryManagerAwareInterface
{
    public function getRepositoryManager();
    public function setRepositoryManager(RepositoryManager $repositoryManager);
}

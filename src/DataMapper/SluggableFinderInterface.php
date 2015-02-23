<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper;

interface SluggableFinderInterface
{
    /**
     * @param  string $slug
     * @return object|null
     */
    public function findBySlug($slug);
}

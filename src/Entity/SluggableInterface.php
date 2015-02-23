<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

interface SluggableInterface
{
    /**
     * @return string
     */
    public function getSlug();

    /**
     * Setting to null should regenerate the slug
     *
     * @param string|null $slug
     */
    public function setSlug($slug);
}

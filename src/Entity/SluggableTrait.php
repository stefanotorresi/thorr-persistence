<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

trait SluggableTrait
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Setting to null should regenerate the slug
     *
     * @param string|null $slug
     */
    public function setSlug($slug)
    {
        if ($slug !== null) {
            $slug = (string) $slug;
        }

        $this->slug = $slug;
    }
}

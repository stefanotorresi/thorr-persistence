<?php
/**
 * @author  Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Test\Asset;

use Thorr\Persistence\Entity\SluggableInterface;
use Thorr\Persistence\Entity\SluggableTrait;

class Entity implements SluggableInterface
{
    use SluggableTrait;
}

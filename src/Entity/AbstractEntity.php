<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Entity;

abstract class AbstractEntity
{
    use FqcnProviderTrait;
    use IdProviderTrait;
}

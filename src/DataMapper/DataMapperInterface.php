<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\DataMapper;

interface DataMapperInterface extends
    EntityFinderInterface,
    EntityRemoverInterface,
    EntitySaverInterface,
    EntityUpdaterInterface
{

}

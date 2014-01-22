<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace MyBase\DataMapper;

interface MapperAwareInterface
{
    /**
     * @param MapperInterface $mapper
     */
    public function setMapper(MapperInterface $mapper);

    /**
     * @return MapperInterface
     */
    public function getMapper();
}

<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Validator;

use Thorr\Persistence\DataMapper\Manager\DataMapperManagerInterface;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

abstract class AbstractEntityValidator extends AbstractValidator
{
    /**
     * @var object
     */
    protected $finder;

    /**
     * @var string
     */
    protected $findMethod;

    /**
     * @var array
     */
    protected $excluded = [];

    /**
     * @var DataMapperManagerInterface
     */
    protected $dataMapperManager;

    /**
     * @param array                      $options
     * @param DataMapperManagerInterface $dataMapperManager
     */
    public function __construct(array $options = null, DataMapperManagerInterface $dataMapperManager = null)
    {
        $this->dataMapperManager = $dataMapperManager;

        if (! isset($options['finder']) && ! isset($options['entity_class'])) {
            throw new Exception\InvalidArgumentException('No finder nor entity class provided');
        }

        if (isset($options['entity_class']) && $this->dataMapperManager) {
            $options['finder'] = $this->dataMapperManager->getDataMapperForEntity($options['entity_class']);
        }

        if (! is_object($options['finder']) && ! is_callable($options['finder'])) {
            throw new Exception\InvalidArgumentException('Finder must be an object or a callable');
        }

        if (! isset($options['find_method'])) {
            $options['find_method'] = is_callable($options['finder']) ? '__invoke' : 'findByUuid';
        }

        if (! method_exists($options['finder'], $options['find_method'])) {
            throw new Exception\InvalidArgumentException(sprintf(
                "'%s' method not found in '%s'",
                $options['find_method'],
                get_class($options['finder'])
            ));
        }

        $this->setFindMethod($options['find_method']);
        $this->setFinder($options['finder']);

        if (isset($options['excluded'])) {
            $this->setExcluded($options['excluded']);
        }

        parent::__construct($options);
    }

    /**
     * @return mixed
     */
    public function getFindMethod()
    {
        return $this->findMethod;
    }

    /**
     * @param mixed $findMethod
     */
    public function setFindMethod($findMethod)
    {
        $this->findMethod = $findMethod;
    }

    /**
     * @return object
     */
    public function getFinder()
    {
        return $this->finder;
    }

    /**
     * @param object $finder
     */
    public function setFinder($finder)
    {
        $this->finder = $finder;
    }

    /**
     * @return array
     */
    public function getExcluded()
    {
        return $this->excluded;
    }

    /**
     * @param mixed $excluded
     */
    public function setExcluded($excluded)
    {
        $this->excluded = (array) $excluded;
    }

    /**
     * @param $value
     *
     * @return array
     */
    protected function findEntity($value)
    {
        $result = $this->finder->{$this->findMethod}($value);

        if ($result === null) {
            return [];
        }

        return (array) $result;
    }
}

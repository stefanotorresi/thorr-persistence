<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Thorr\Persistence\Validator;

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
     * @param  array                              $options
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(array $options = null)
    {
        if (! isset($options['finder'])) {
            throw new Exception\InvalidArgumentException('No finder provided');
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
        if (! is_array($excluded)) {
            $excluded = [ $excluded ];
        }

        $this->excluded = $excluded;
    }

    /**
     * @param $value
     * @return array
     */
    protected function findResult($value)
    {
        $result = $this->finder->{$this->findMethod}($value);

        if ($result === null) {
            return [];
        }

        if (! is_array($result)) {
            return [ $result ];
        }

        return $result;
    }
}

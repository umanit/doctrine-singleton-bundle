<?php

namespace Umanit\DoctrineSingletonBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Umanit\DoctrineSingletonBundle\Model\SingletonInterface;

/**
 * Event to filter singletons.
 */
class FilterSingletonEvent extends Event
{
    const SINGLETON_FILTER_EVENT = 'umanit_doctrine_singleton.filter';

    /**
     * @var SingletonInterface
     */
    private $entity;

    /**
     * @var array
     */
    private $filters;

    /**
     * Constructor.
     *
     * @param SingletonInterface $entity
     * @param array              $filters
     */
    public function __construct($entity, $filters)
    {
        $this->entity  = $entity;
        $this->filters = $filters;
    }

    /**
     * Set entity.
     *
     * @param string $entity
     *
     * @return self
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity.
     *
     * @return SingletonInterface
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set filters.
     *
     * @param array $filters
     *
     * @return self
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Get filters.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }
}

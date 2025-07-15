<?php

namespace Umanit\DoctrineSingletonBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Umanit\DoctrineSingletonBundle\Model\SingletonInterface;

/**
 * Event to filter singletons.
 */
class FilterSingletonEvent extends Event
{
    public const SINGLETON_FILTER_EVENT = 'umanit_doctrine_singleton.filter';

    private ?SingletonInterface $entity;
    private ?array $filters;

    public function __construct(SingletonInterface $entity, array $filters)
    {
        $this->entity = $entity;
        $this->filters = $filters;
    }

    public function setEntity(?SingletonInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getEntity(): SingletonInterface
    {
        return $this->entity;
    }

    public function setFilters(?array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }
}

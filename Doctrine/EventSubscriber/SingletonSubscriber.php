<?php

namespace Umanit\DoctrineSingletonBundle\Doctrine\EventSubscriber;

use Doctrine\ORM;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Umanit\DoctrineSingletonBundle\Event\FilterSingletonEvent;
use Umanit\DoctrineSingletonBundle\Exceptions\NonUniqueException;
use Umanit\DoctrineSingletonBundle\Model\SingletonInterface;

/**
 * Subscriber that checks that an entity which implements the SingletonInterface, is unique.
 */
class SingletonSubscriber
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getSubscribedEvents(): array
    {
        return [ORM\Events::prePersist];
    }

    /**
     * @throws NonUniqueException
     */
    public function prePersist(ORM\Event\PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof SingletonInterface) {
            $className = $args->getObjectManager()->getClassMetadata($entity::class)->getName();
            $filters = [];

            // Event to add filters
            $event = new FilterSingletonEvent($entity, $filters);
            $this->eventDispatcher->dispatch($event, FilterSingletonEvent::SINGLETON_FILTER_EVENT);

            $filters = $event->getFilters();

            if ($args->getObjectManager()->getRepository($className)->findBy($filters)) {
                throw new NonUniqueException(sprintf('Entity %s already exists', $className));
            }
        }
    }
}

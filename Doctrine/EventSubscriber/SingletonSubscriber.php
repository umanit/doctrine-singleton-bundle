<?php

namespace Umanit\DoctrineSingletonBundle\Doctrine\EventSubscriber;

use Doctrine\Common;
use Doctrine\ORM;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Umanit\DoctrineSingletonBundle\Event\FilterSingletonEvent;
use Umanit\DoctrineSingletonBundle\Exceptions\NonUniqueException;
use Umanit\DoctrineSingletonBundle\Model\SingletonInterface;
use Umanit\TranslationBundle\Doctrine\Model\TranslatableInterface;

/**
 * Subscriber that checks that en entity which implements the SingletonInterface, is unique.
 */
class SingletonSubscriber implements Common\EventSubscriber
{
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [ORM\Events::prePersist];
    }

    /**
     * @param ORM\Event\LifecycleEventArgs $args
     *
     * @throws NonUniqueException
     */
    public function prePersist(ORM\Event\LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof SingletonInterface) {
            $className = $args->getObjectManager()->getClassMetadata(get_class($entity))->getName();
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

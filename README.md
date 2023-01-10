# Doctrine Singleton Bundle

This bundle intends to easily create complex singleton entities (totally unique, or based on some properties).
Sonata Admin friendly with automatic integration.

## Install

Register the bundle to your 'app/AppKernel.php'

```php
    new Umanit\DoctrineSingletonBundle\UmanitDoctrineSingletonBundle(),
```

That's it!

## Usage

### Tell that your entity is a singleton

Just need to implement the `Umanit\DoctrineSingletonBundle\Model\SingletonInterface`
```php
<?php

namespace App\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Umanit\DoctrineSingletonBundle\Model\SingletonInterface;

#[ORM\Table(name="page")]
class Page implements SingletonInterface 
{
}
```

Now, if you try to create 2 entities of type "Page", you'll get a `NonUniqueException`

### More complex unicity

If you want to implement a more complex unicity, for example, you want the entity to be unique per local, you can subscribe to the
`FilterSingletonEvent::SINGLETON_FILTER_EVENT` event to modify the `filters` (filters are used in a `findBy()` clause)

e.g (from [TranslationBundle](https://github.com/umanit/translation-bundle))
```php
 <?php

namespace Umanit\TranslationBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Umanit\DoctrineSingletonBundle\Event\FilterSingletonEvent;
use Umanit\TranslationBundle\Doctrine\Model\TranslatableInterface;

class SingletonSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [FilterSingletonEvent::SINGLETON_FILTER_EVENT => ['onFilterEvent']];
    }

    public function onFilterEvent(FilterSingletonEvent $event)
    {
        $entity  = $event->getEntity();
        $filters = $event->getFilters();

        if ($entity instanceof TranslatableInterface) {
            $filters['locale'] = $entity->getLocale();
        }

        $event->setFilters($filters);
    }
}
```

`services.yml`
```yaml
 services:
    umanit_translation.event_subscriber.doctrine_singleton_filter:
        class: Umanit\TranslationBundle\EventSubscriber\SingletonSubscriber
        tags:
            - { name: kernel.event_subscriber } 
```

### Get singleton

In order to get your singleton instances, you can use the provided helpers for your PHP code or twig :

```php
<?php

$this->get('umanit_doctrine_singleton.helper')->getSingleton('App\Entity\Page::class');
```

```twig
{% set singleton = get_singleton('App\\Entity\\Page') %}
```

The method `getSingleton($className, array $filters = [], $instantiateIfNotFound = false)` can take from 1 to 3 arguments :
- `$className` : FQCN of the class to get
- `$filters` : Filters to apply to get the singleton (e.g. : `getSingleton("MyClass", ["locale" => "en"])`)
- `$instantiateIfNotFound` : If the entity is not found, returns an empty entity instead of `null`

## Integrating into SonataAdmin

The bundle will automatically remove `add` and `list` button from the list and the edit view.

If you use the `UmanitDoctrineSingletonBundle:Sonata\SingletonCRUD` as a controller for your admin class, you'll have a redirection
to `create` if there's no entity found, to `edit` if there's only one, and to `list` if you have more than one.

e.g :
```yaml
     app.admin.page:
         class: App\Admin\PageAdmin
         arguments: [~, App\Entity\Content\Page, UmanitDoctrineSingletonBundle:Sonata\SingletonCRUD ]
         tags:
             - { name: sonata.admin, manager_type: orm, group: 'Content', label: 'Page' }
```

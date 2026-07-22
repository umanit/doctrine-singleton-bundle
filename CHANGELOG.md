# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [3.0.0] - 2026-07-22

### Changed

- Minimum PHP version bump to 8.2
- Widen doctrine/doctrine-bundle to ^2.7|^3.0
- Replace deprecated psr-0 autoload with psr-4, remove target-dir
- Replace deprecated LifecycleEventArgs|PrePersistEventArgs union type
  with PrePersistEventArgs (ORM 3.x only)
- Replace get_class($entity) with $entity::class

### Removed

- Remove implements Doctrine\Common\EventSubscriber from
  SingletonSubscriber: this interface was removed in doctrine/event-
  manager 2.x (used by doctrine/orm 3.x). The doctrine.event_subscriber
  service tag only requires getSubscribedEvents() to be present.
- Remove unused import of umanit/translation-bundle TranslatableInterface

## [2.0.5] - 2025-08-06

### Fixed

- Add missing type-hint on `SingletonSubscriber::prePersist`

## [2.0.4] - 2025-07-28

### Added

- Add support for doctrine/orm 3.x

## [2.0.3] - 2023-01-12

### Fixed

- Fixes `SingletonCRUDController` service and alias declaration

## [2.0.2] - 2023-01-11

- With the files, it's better...

## [2.0.1] - 2023-01-11

### Fixed

- Rename configuration files

## 2.0.0 - 2023-01-11

### Changed

- Makes the bundle compatible with PHP >= 8.0
- Makes the bundle compatible with Symfony >= 5.0
- Makes the bundle compatible with Doctrine ORM >= 2.13

### Removed

- Drops support for PHP < 8.0
- Drops support for Symfony < 5.0
- Removes useless `Configuration` file

## Added

- Adds stricter typing, wherever possible, to properties, method signatures and return values
- Adds an alias (`umanit_doctrine_singleton.controller.singleton_crudcontroller`) for the `SingletonCRUDController`
- Initial version of this CHANGELOG

[Unreleased]: https://github.com/umanit/doctrine-singleton-bundle/compare/3.0.0...HEAD

[3.0.0]: https://github.com/umanit/doctrine-singleton-bundle/compare/2.0.5...3.0.0

[2.0.5]: https://github.com/umanit/doctrine-singleton-bundle/compare/2.0.4...2.0.5

[2.0.4]: https://github.com/umanit/doctrine-singleton-bundle/compare/2.0.3...2.0.3

[2.0.3]: https://github.com/umanit/doctrine-singleton-bundle/compare/2.0.2...2.0.3

[2.0.2]: https://github.com/umanit/doctrine-singleton-bundle/compare/2.0.1...2.0.2

[2.0.1]: https://github.com/umanit/doctrine-singleton-bundle/compare/2.0.0...2.0.1

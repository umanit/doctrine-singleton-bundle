<?php

namespace Umanit\DoctrineSingletonBundle\Helper;

use Symfony\Bridge\Doctrine\ManagerRegistry;

/**
 * Utilities to manipulate/retrieve singletons.
 */
class SingletonHelper
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Retrieve a singleton of $className.
     *
     * @param string $className             FQCN of the class to get
     * @param array  $filters               (optional) filters to get the singleton
     * @param bool   $instantiateIfNotFound instantiate the singleton if it is not found (not saved)
     *
     * @return mixed
     */
    public function getSingleton(string $className, array $filters = [], bool $instantiateIfNotFound = false)
    {
        $singleton = $this->doctrine->getRepository($className)->findOneBy($filters);

        if (!$singleton && $instantiateIfNotFound) {
            return new $className();
        }

        return $singleton;
    }
}

<?php

namespace Umanit\DoctrineSingletonBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Umanit\DoctrineSingletonBundle\Helper\SingletonHelper;

/**
 * Twig helpers
 */
class SingletonExtension extends AbstractExtension
{
    private SingletonHelper $singletonHelper;

    public function __construct(SingletonHelper $singletonHelper)
    {
        $this->singletonHelper = $singletonHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_singleton', [$this->singletonHelper, 'getSingleton']),
        ];
    }
}

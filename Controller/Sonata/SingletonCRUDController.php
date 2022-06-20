<?php

namespace Umanit\DoctrineSingletonBundle\Controller\Sonata;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sonata\AdminBundle\Controller\CRUDController;
use Umanit\MultiSiteBundle\Utils\SiteAccessesManager;

/**
 * Sonata controller to manage singletons
 */
class SingletonCRUDController extends CRUDController
{
    /**
     * {@inheritdoc}
     */
    public function listAction()
    {
        /** @var Paginator $resultList */
        $resultList = $this->admin->getDatagrid()->getResults();

        if ($resultList->count() > 1) {
            return parent::listAction();
        }

        if (1 === $resultList->count()) {
            $result = $resultList->getIterator()->current();
            return $this->redirect($this->admin->generateObjectUrl('edit', $result));
        }

        return $this->redirect($this->admin->generateUrl('create'));
    }
}

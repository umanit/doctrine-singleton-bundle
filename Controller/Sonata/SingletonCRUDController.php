<?php

namespace Umanit\DoctrineSingletonBundle\Controller\Sonata;

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
        /** @var Paginator|array $resultList */
        $resultList = $this->admin->getDatagrid()->getResults();

        if ($resultList instanceof Paginator) {
            if ($resultList->count() > 1) {
                return parent::listAction();
            }

            if (1 === $resultList->count()) {
                $result = $resultList->getIterator()->current();
                return $this->redirect($this->admin->generateObjectUrl('edit', $result));
            }
        } else {
            $result = $this->admin->getDatagrid()->getResults();
            if (count($result) > 1) {
                return parent::listAction();
            }

            if (count($result) === 1) {
                return $this->redirect($this->admin->generateObjectUrl('edit', $result[0]));
            }
        }

        return $this->redirect($this->admin->generateUrl('create'));
    }
}

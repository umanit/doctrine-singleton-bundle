<?php

namespace Umanit\DoctrineSingletonBundle\Controller\Sonata;

use Doctrine\ORM\EntityManagerInterface;
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
        $result = $this->admin->getDatagrid()->getResults();
        if (count($result) > 1) {
            return parent::listAction();
        }

        if (count($result) === 1) {
            return $this->redirect($this->admin->generateObjectUrl('edit', $result[0]));
        }

        return $this->redirect($this->admin->generateUrl('create'));
    }
}

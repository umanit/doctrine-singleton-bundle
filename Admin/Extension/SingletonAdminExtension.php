<?php

namespace Umanit\DoctrineSingletonBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;

class SingletonAdminExtension extends AbstractAdminExtension
{
    public function configureActionButtons(
        AdminInterface $admin,
        array $list,
        string $action,
        ?object $object = null
    ): array {
        // No create action on edit object
        if ($object && isset($list['create'])) {
            unset($list['create']);
        }

        // No view list on edit object
        if ($object && isset($list['list'])) {
            unset($list['list']);
        }

        // No add in list mode if already an entity
        if (!$object) {
            if ($admin->getModelManager()->findBy($admin->getClass(), []) && isset($list['create'])) {
                unset($list['create']);
            }
        }

        return $list;
    }
}

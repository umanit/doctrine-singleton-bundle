<?php

namespace Umanit\DoctrineSingletonBundle\Admin\Extension;

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;

/**
 * SonataAdmin Extension.
 *
 * @author Axel Anceau <aanceau@umanit.fr>
 */
class SingletonAdminExtension extends AbstractAdminExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureActionButtons(AdminInterface $admin, $list, $action, $object)
    {
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

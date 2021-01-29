<?php


namespace app\modules\user\models\tool;


class BehaviorsRoleManager
{
    public static function extendRoles(&$oldRoles, $newRoles)
    {
        $resultRoles = [];
        if (is_array($newRoles)) {
            foreach ($newRoles as $newRole) {
                array_push($resultRoles, $newRole);
            }
        }

        $oldRoles = array_merge($resultRoles, $oldRoles);
    }
}
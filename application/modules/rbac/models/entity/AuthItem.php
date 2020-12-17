<?php

namespace app\modules\rbac\models\entity;

use app\modules\rbac\models\entity\AuthItemChild;
use app\modules\site\models\tools\Debug;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * AuthItem model
 *
 * @property string $name
 * @property string $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class AuthItem extends \yii\db\ActiveRecord
{
    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;

    public $format_name;
    public $parent;
    public $permissionsGroup;

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'parent' => 'Родительская группа',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '{attribute} должно быть заполнено'],
            ['name', 'unique', 'targetClass' => AuthItem::className()],

            ['description', 'string'],

            ['parent', 'string'],

            ['permissionsGroup', 'safe'],
        ];
    }

    public function createPermission()
    {
        $permission = Yii::$app->authManager->createPermission($this->name);
        $permission->description = $this->description;
        Yii::$app->authManager->add($permission);

        return true;
    }

    public function createRole()
    {
        $auth = \Yii::$app->authManager;

        $role = $auth->createRole($this->name);
        $role->description = $this->description;
        $auth->add($role);
        return true;
    }

    public function updateRole()
    {
        $auth = \Yii::$app->authManager;

        $role = $auth->getRole($this->name);


        return true;
    }

    public function applyParentGroup($role, $parentRole)
    {
        $authManager = Yii::$app->authManager;
        $roleGroup = $authManager->getRole($role);
        $parentRoleGroup = $authManager->getRole($parentRole);
        return $authManager->addChild($parentRoleGroup, $roleGroup);
    }

    public function applyPermissions($role, $permissions)
    {

        $authManager = Yii::$app->authManager;
        $roleObject = $authManager->getRole($role);

        foreach ($permissions as $permission) {
            $permissionObject = $authManager->getPermission($permission);
            $authManager->addChild($roleObject,$permissionObject);
        }

        return true;

    }

    public function getChilds()
    {
        $child_names = AuthItemChild::find()->where(['parent' => $this->name])->select('child')->all();

        return static::find()->where(['name' => ArrayHelper::getColumn($child_names, 'child')])->all();

    }

    public $items = array();

    public function threeGroups($name = null, $delim = "")
    {
        if ($name == null) {
            $groups = AuthItem::find()->where(['type' => AuthItem::TYPE_ROLE])->andWhere(['not in', 'name', ArrayHelper::getColumn(AuthItemChild::find()->all(), 'child')])->all();
        } else {
            $groups = AuthItem::find()
                ->where(['type' => AuthItem::TYPE_ROLE])
                ->andWhere(['like', 'name', ArrayHelper::getColumn(AuthItemChild::find()->where(['parent' => $name])->all(), 'child')])
                ->all();
        }

        if ($groups) {

            foreach ($groups as &$group) {
                $group->format_name = $delim . $group->name;
                $this->items[] = $group;
                self::threeGroups($group->name, $delim . '---');
            }

        }

        return $this->items;
    }

    public function getParents()
    {
        return $this->hasOne(AuthItemChild::className(), ['child' => 'name']);
    }
}
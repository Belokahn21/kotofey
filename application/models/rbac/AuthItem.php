<?php

namespace app\models\rbac;

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

        if (!empty($this->parent)) {

            $parentRole = $auth->getRole($this->parent);
            $auth->addChild($parentRole, $role);

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
}
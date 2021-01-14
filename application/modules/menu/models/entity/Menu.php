<?php

namespace app\modules\menu\models\entity;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name
 * @property string $is_active
 * @property string|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property MenuItem[] $menuItems
 */
class Menu extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['name', 'is_active'], 'required'],
            [['sort'], 'default', 'value' => 500],
            [['is_active'], 'default', 'value' => 1],
            [['name', 'is_active', 'sort'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[MenuItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id']);
    }
}

<?php

namespace app\modules\menu\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "menu_item".
 *
 * @property int $id
 * @property string|null $name
 * @property string $link
 * @property int|null $parent_id
 * @property int|null $is_active
 * @property int $menu_id
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Menu $menu
 */
class MenuItem extends \yii\db\ActiveRecord
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
            [['parent_id', 'is_active', 'menu_id', 'sort',], 'integer'],
            [['menu_id', 'link'], 'required'],
            [['sort'], 'default', 'value' => 500],
            [['name'], 'string', 'max' => 255],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'link' => 'Ссылка',
            'parent_id' => 'ID родителя',
            'is_active' => 'Активность',
            'menu_id' => 'ID меню',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }
}

<?php

namespace app\modules\catalog\models\entity;

use Yii;

/**
 * This is the model class for table "properties".
 *
 * @property int $id
 * @property int $group_id
 * @property int $is_active
 * @property int $is_multiple
 * @property int $is_offer_catalog
 * @property int $is_show_site
 * @property string $name
 * @property int $sort
 * @property int|null $type
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property PropertiesVariants[] $propertiesVariants
 */
class Properties extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['is_active', 'is_multiple', 'is_offer_catalog', 'is_show_site', 'sort', 'type', 'group_id'], 'integer'],
            ['sort', 'default', 'value' => 500],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Группа',
            'is_active' => 'Активность',
            'is_multiple' => 'Множественный выбор',
            'is_offer_catalog' => 'Свойство торгового каталога',
            'is_show_site' => 'Показать на сайте',
            'name' => 'Название',
            'sort' => 'Сортировка',
            'type' => 'Тип свойства',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getPropertiesVariants()
    {
        return $this->hasMany(PropertiesVariants::className(), ['property_id' => 'id']);
    }

    public function getGroup()
    {
        return $this->hasOne(PropertyGroup::className(), ['id' => 'group_id']);
    }
}
